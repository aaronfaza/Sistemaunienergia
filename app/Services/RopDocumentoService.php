<?php

namespace App\Services;

use App\Exceptions\RopDiskNoDisponibleException;
use App\Models\LogisticaLote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Sube/reemplaza/sirve los documentos (carta, cotización, requerimiento) de
 * cualquiera de los 6 tipos de Carta, guardándolos en el disco de red
 * 'rop2026' (\\Hp-server\Operaciones\LOGISTICA\ROP 2026). Reutilizado por los
 * 6 controladores de carta para no repetir esta lógica 6 veces.
 */
class RopDocumentoService
{
    public const DISK = 'rop2026';
    public const CAMPOS = ['carta', 'cotizacion', 'requerimiento'];

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
     * @return array{origen: 'red'|'bd', carpetas: array<int, string>}
     */
    public function listarCarpetas(): array
    {
        if ($this->mountDisponible()) {
            try {
                $carpetas = Cache::remember('rop2026_carpetas', 45, function () {
                    return Storage::disk(self::DISK)->directories();
                });

                return ['origen' => 'red', 'carpetas' => $carpetas];
            } catch (\Throwable $e) {
                // Cae al fallback de abajo.
            }
        }

        $carpetas = LogisticaLote::whereNotNull('cod_log')
            ->distinct()
            ->orderBy('cod_log')
            ->pluck('cod_log')
            ->all();

        return ['origen' => 'bd', 'carpetas' => $carpetas];
    }

    /**
     * Sube los archivos presentes en $archivos (claves: carta, cotizacion,
     * requerimiento) a la carpeta indicada, y arma el array de columnas a
     * mezclar en $data antes de create()/update() de la carta. Los campos
     * ausentes o null en $archivos no se tocan (permite reemplazar solo uno
     * de los 3 documentos, o solo cambiar la carpeta sin resubir nada).
     *
     * @param array<string, UploadedFile|null> $archivos
     * @return array<string, mixed>
     *
     * @throws RopDiskNoDisponibleException
     * @throws InvalidArgumentException
     */
    public function guardarDocumentos(Model $carta, array $archivos, ?string $carpeta): array
    {
        $archivos = array_filter(
            array_intersect_key($archivos, array_flip(self::CAMPOS)),
            fn ($file) => $file instanceof UploadedFile
        );

        $carpeta = ($carpeta !== null && trim($carpeta) !== '') ? $this->sanitizarCarpeta($carpeta) : null;

        if (empty($archivos) && $carpeta === null) {
            return [];
        }

        $resultado = [];

        if ($carpeta !== null) {
            $resultado['carpeta_rop'] = $carpeta;
        }

        if (empty($archivos)) {
            return $resultado;
        }

        if (!$this->mountDisponible()) {
            throw new RopDiskNoDisponibleException();
        }

        $carpetaDestino = $carpeta ?? $carta->carpeta_rop;

        if (!$carpetaDestino) {
            throw new InvalidArgumentException('Debe indicar la carpeta ROP de destino antes de subir documentos.');
        }

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

            $path = $file->storeAs($carpetaDestino, $nombre, self::DISK);

            if (!$path || Storage::disk(self::DISK)->size($path) !== $file->getSize()) {
                if ($path) {
                    Storage::disk(self::DISK)->delete($path);
                }

                throw new RopDiskNoDisponibleException();
            }

            $rutasAnteriores[$columna] = $carta->getOriginal($columna);
            $resultado[$columna] = $path;
        }

        // Recién ahora, con los archivos nuevos ya confirmados en el disco,
        // se borran los anteriores — si la red se hubiera caído a mitad de la
        // subida del nuevo, es preferible quedarse con el viejo intacto.
        foreach ($rutasAnteriores as $pathAnterior) {
            $this->eliminarDocumento($pathAnterior);
        }

        // Reemplazar el documento de la carta invalida cualquier verificación
        // previa: no puede seguir figurando "verificado" un documento distinto
        // al que el admin realmente revisó. Se aplica con forceFill() directo
        // sobre el modelo (no vía el array $resultado) porque estos 3 campos
        // están deliberadamente fuera de $fillable — si viajaran en $resultado,
        // el update($data) del controlador los descartaría en silencio por la
        // protección de asignación masiva.
        if (isset($resultado['archivo_carta']) && $carta->firmado_verificado) {
            $carta->forceFill([
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

    private function sanitizarCarpeta(string $carpeta): string
    {
        $carpeta = trim($carpeta);

        if ($carpeta === '' || !preg_match('/^[A-Za-z0-9 _\-]+$/', $carpeta)) {
            throw new InvalidArgumentException('Nombre de carpeta inválido.');
        }

        return $carpeta;
    }
}
