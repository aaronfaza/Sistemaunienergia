<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait OptimizaFoto
{
    /**
     * Redimensiona y comprime una foto subida para que ocupe como máximo ~1MB,
     * probando calidades JPEG decrecientes hasta bajar del límite (o llegar
     * al piso de calidad). Si GD no puede leer el archivo, lo guarda tal cual.
     */
    private function guardarFotoOptimizada($file, string $folder, int $maxDim = 1920, int $maxBytes = 1024 * 1024): string
    {
        $path = $file->getRealPath();
        $info = @getimagesize($path);

        if (!$info) {
            return $file->store($folder, 'public');
        }

        $imagen = match ($info[2]) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG => imagecreatefrompng($path),
            IMAGETYPE_WEBP => imagecreatefromwebp($path),
            default => null,
        };

        if (!$imagen) {
            return $file->store($folder, 'public');
        }

        // Corrige orientación EXIF (fotos de cámara suelen venir "rotadas" a nivel de metadata)
        if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $exif = @exif_read_data($path);
            $orientacion = $exif['Orientation'] ?? null;
            $imagen = match ($orientacion) {
                3 => imagerotate($imagen, 180, 0),
                6 => imagerotate($imagen, -90, 0),
                8 => imagerotate($imagen, 90, 0),
                default => $imagen,
            };
        }

        // Redimensiona si excede el tamaño máximo permitido
        $ancho = imagesx($imagen);
        $alto = imagesy($imagen);
        $ratio = min($maxDim / $ancho, $maxDim / $alto, 1);

        if ($ratio < 1) {
            $nuevoAncho = (int) round($ancho * $ratio);
            $nuevoAlto = (int) round($alto * $ratio);
            $redimensionada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
            imagecopyresampled($redimensionada, $imagen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
            imagedestroy($imagen);
            $imagen = $redimensionada;
        }

        // Comprime iterativamente en JPEG hasta bajar de $maxBytes (o piso de calidad)
        $calidad = 85;
        do {
            ob_start();
            imagejpeg($imagen, null, $calidad);
            $datos = ob_get_clean();
            $calidad -= 10;
        } while (strlen($datos) > $maxBytes && $calidad >= 25);

        imagedestroy($imagen);

        $nombreArchivo = trim($folder, '/') . '/' . uniqid('foto_') . '.jpg';
        Storage::disk('public')->put($nombreArchivo, $datos);

        return $nombreArchivo;
    }
}
