<?php

namespace App\Exceptions;

use Exception;

/**
 * Se lanza cuando el disco de red 'rop2026' (\\Hp-server\...\ROP 2026) no
 * responde al momento de subir un documento. Los controladores la capturan
 * para devolver un mensaje claro al usuario en vez de un 500 genérico.
 */
class RopDiskNoDisponibleException extends Exception
{
    protected $message = 'No se pudo conectar con el servidor de archivos ROP2026. Intente nuevamente en unos minutos.';
}
