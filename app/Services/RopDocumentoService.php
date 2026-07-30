<?php

namespace App\Services;

use App\Exceptions\RopDiskNoDisponibleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Sube/reemplaza/sirve los documentos de un expediente ROP2026, respetando la
 * estructura real de carpetas que usa Logística en el disco de red
 * (\\Hp-server\Operaciones\LOGISTICA\ROP 2026\{cod_log}\01 CARTA, 02
 * PROPUESTA, 03 EVALUACION, 04 ORDEN, 05 INFORMES / 05 GRE, 06 CONFORMIDAD,
 * 07 FACTURA). El cod_log que Admin escribe al crear el registro ES el
 * nombre de la carpeta raíz del expediente en el share.
 */
class RopDocumentoService
{
    public const DISK = 'rop2026';

    /**
     * Subcarpeta real donde va cada tipo de documento, según el orden de
     * proceso mostrado en el explorador de archivos de Logística. '05
     * INFORMES' y '05 GRE' son excluyentes (servicio vs. compra), pero se
     * crean ambas de una vez porque tipo_solicitud recién se define después
     * del registro inicial del ROP.
     */
    public const SUBCARPETA_POR_CAMPO = [
        'carta' => '01 CARTA',
        'carta_jefe_operaciones' => '01 CARTA',
        'requerimiento' => '01 CARTA',
        'cotizacion_1' => '02 PROPUESTA',
        'cotizacion_2' => '02 PROPUESTA',
        'cotizacion_3' => '02 PROPUESTA',
        'cotizacion_4' => '02 PROPUESTA',
        'cotizacion_5' => '02 PROPUESTA',
        'cotizacion_6' => '02 PROPUESTA',
        'acta_comite' => '03 EVALUACION',
        'certificacion_presupuestal' => '03 EVALUACION',
        'orden' => '04 ORDEN',
        'informe' => '05 INFORMES',
        'gre' => '05 GRE',
        'conformidad' => '06 CONFORMIDAD',
        'factura' => '07 FACTURA',
    ];

    public const CAMPOS = [
        'carta', 'carta_jefe_operaciones', 'requerimiento',
        'cotizacion_1', 'cotizacion_2', 'cotizacion_3', 'cotizacion_4', 'cotizacion_5', 'cotizacion_6',
        'acta_comite', 'certificacion_presupuestal',
        'orden', 'informe', 'gre', 'conformidad', 'factura',
    ];

    /**
     * El mount CIFS puede caerse dejando /mnt/rop2026 como una carpeta local
     * vacía en vez de desaparecer del todo. Comprobar solo Storage::exists('/')
     * no distingue ambos casos, así que se verifica un archivo canario fijo
     * que infraestructura crea una sola vez en la raíz del share real.
     */
    public function mountDisponible(): bool
    {
        try {
            return Storage::disk(self::DISK)->exists('.mount_ok');
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Sube los archivos presentes en $archivos (claves: ver CAMPOS) dentro de
     * la subcarpeta real que corresponde a cada tipo (ver
     * SUBCARPETA_POR_CAMPO), y arma el array de columnas a mezclar en $data
     * antes de create()/update() del registro. Los campos ausentes o null en
     * $archivos no se tocan.
     *
     * @param array<string, UploadedFile|null> $archivos
     * @return array<string, mixed>
     *
     * @throws RopDiskNoDisponibleException
     * @throws InvalidArgumentException
     */
    public function guardarDocumentos(Model $modelo, array $archivos, string $carpeta): array
    {
        $archivos = array_filter(
            array_intersect_key($archivos, array_flip(self::CAMPOS)),
            fn ($file) => $file instanceof UploadedFile
        );

        if (empty($archivos)) {
            return [];
        }

        if (!$this->mountDisponible()) {
            throw new RopDiskNoDisponibleException();
        }

        $carpeta = $this->sanitizarCarpeta($carpeta);

        $resultado = [];
        $rutasAnteriores = [];

        foreach ($archivos as $campo => $file) {
            $columna = "archivo_{$campo}";
            $rutaCarpeta = $carpeta . '/' . self::SUBCARPETA_POR_CAMPO[$campo];
            $nombre = sprintf(
                '%s_%s_%s.%s',
                $campo,
                now()->format('Ymd_His'),
                Str::random(8),
                strtolower($file->getClientOriginalExtension())
            );

            $path = $file->storeAs($rutaCarpeta, $nombre, self::DISK);

            if (!$path || Storage::disk(self::DISK)->size($path) !== $file->getSize()) {
                if ($path) {
                    Storage::disk(self::DISK)->delete($path);
                }

                throw new RopDiskNoDisponibleException();
            }

            $rutasAnteriores[$columna] = $modelo->getOriginal($columna);
            $resultado[$columna] = $path;
        }

        // Recién ahora, con los archivos nuevos ya confirmados en el disco,
        // se borran los anteriores — si la red se hubiera caído a mitad de la
        // subida del nuevo, es preferible quedarse con el viejo intacto.
        foreach ($rutasAnteriores as $pathAnterior) {
            $this->eliminarDocumento($pathAnterior);
        }

        // Reemplazar cualquiera de las cartas (área solicitante o jefe de
        // operaciones) invalida cualquier verificación previa: no puede
        // seguir figurando "verificado" un documento distinto al que el
        // admin realmente revisó. Se aplica con forceFill() directo sobre el
        // modelo (no vía $resultado) porque estos 3 campos están
        // deliberadamente fuera de $fillable — si viajaran en $resultado, el
        // update($data) del controlador los descartaría en silencio.
        if (
            (isset($resultado['archivo_carta']) || isset($resultado['archivo_carta_jefe_operaciones']))
            && $modelo->firmado_verificado
        ) {
            $modelo->forceFill([
                'firmado_verificado' => false,
                'verificado_por' => null,
                'verificado_en' => null,
            ]);
        }

        return $resultado;
    }

    public function eliminarDocumento(?string $path): void
    {
        if ($path && Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    /**
     * Crea la carpeta del ROP y sus 7 subcarpetas reales (idempotente),
     * aunque todavía no se suba ningún documento — así el expediente queda
     * listo para recibir archivos (subidos después, o copiados manualmente
     * por Logística Lima mientras esta carpeta se comparte con Lima) desde
     * el momento en que se registra el ROP.
     */
    public function crearCarpeta(string $carpeta): void
    {
        if (!$this->mountDisponible()) {
            throw new RopDiskNoDisponibleException();
        }

        $carpeta = $this->sanitizarCarpeta($carpeta);

        if (!Storage::disk(self::DISK)->exists($carpeta)) {
            Storage::disk(self::DISK)->makeDirectory($carpeta);
        }

        foreach (array_unique(array_values(self::SUBCARPETA_POR_CAMPO)) as $subcarpeta) {
            $ruta = $carpeta . '/' . $subcarpeta;
            if (!Storage::disk(self::DISK)->exists($ruta)) {
                Storage::disk(self::DISK)->makeDirectory($ruta);
            }
        }
    }

    private function sanitizarCarpeta(string $carpeta): string
    {
        $carpeta = trim($carpeta);

        if ($carpeta === '' || !preg_match('/^[A-Za-z0-9 _\-]+$/', $carpeta)) {
            throw new InvalidArgumentException('Nombre de carpeta (cod_log) inválido para el disco de red.');
        }

        return $carpeta;
    }
}
