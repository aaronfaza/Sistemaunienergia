<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodigoRecuperacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $usuario,
        public string $codigo,
        public int $minutosValidez,
    ) {
    }

    public function build()
    {
        return $this->subject('Código para recuperar tu contraseña - UniEnergía ABC')
            ->view('emails.codigo-recuperacion');
    }
}
