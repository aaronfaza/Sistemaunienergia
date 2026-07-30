<?php

namespace App\Services;

use App\Exceptions\RopDiskNoDisponibleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Sube/reemplaza/sirve los documentos (carta, cotización, requerimiento) de
 * un expediente ROP2026, guardándolos en el disco de red 'rop2026'
 * (\\Hp-server\Operaciones\LOGISTICA\ROP 2026), dentro de la carpeta que ya
 * corresponde a ese ROP (cod_log, ej. "ROP260298") — no hay selector de
 * carpeta aparte, el cod_log que Admin ya escribe al crear el registro ES el
 * nombre de la carpeta real en el share.
 */
class RopDocumentoService
{
    public const DISK = 'rop2026';

    // 'carta' (área solicitante), 'carta_jefe_operaciones' (obligatoria solo
    // si la compra/servicio supera US$ 1,000 — no se valida automático,
    // depende de un criterio que Admin ya conoce al registrar), 'cotizacion_1'
    // a 'cotizacion_6' (1 a 6 cotizaciones según el proceso) y 'requerimiento'
    // los sube Admin al registrar el ROP; 'orden'/'acta_comite' los sube
    // Logística Lima como parte de su propio proceso.
    public const CAMPOS = [
        'carta', 'carta_jefe_operaciones',
        'cotizacion_1', 'cotizacion_2', 'cotizacion_3', 'cotizacion_4', 'cotizacion_5', 'cotizacion_6',
        'requerimiento', 'orden', 'acta_comite',
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
     * Sube los archivos presentes en $archivos (claves: carta, cotizacion,
     * requerimiento) a la carpeta $carpeta (el cod_log del ROP), y arma el
     * array de columnas a mezclar en $data antes de create()/update() del
     * registro. Los campos ausentes o null en $archivos no se tocan.
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
            $nombre = sprintf(
                '%s_%s_%s.%s',
                $campo,
                now()->format('Ymd_His'),
                Str::random(8),
                strtolower($file->getClientOriginalExtension())
            );

            $path = $file->storeAs($carpeta, $nombre, self::DISK);

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
     * Crea la carpeta del ROP en el disco (idempotente) aunque todavía no se
     * suba ningún documento — así el expediente queda listo para recibir
     * archivos (subidos después, o copiados manualmente por Logística Lima
     * mientras esta carpeta se comparte con Lima) desde el momento en que se
     * registra el ROP.
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
