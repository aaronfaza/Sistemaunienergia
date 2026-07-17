<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cargo',
        'rol',
        'firma_pin',
        'firma_imagen',
    ];

    /**
     * ¿El usuario solo tiene acceso al módulo de Mantenimiento (mecánico)?
     * Este rol además NO puede editar/eliminar reportes ni anomalías.
     */
    public function esSoloMantenimiento(): bool
    {
        return $this->rol === 'mecanico';
    }

    /**
     * ¿Es el supervisor de mantenimiento? Puede firmar reportes localmente.
     */
    public function esSupervisorMantenimiento(): bool
    {
        return $this->rol === 'supervisor';
    }

    /**
     * ¿El menú de este usuario debe limitarse a Mantenimiento + Anomalías?
     * Aplica tanto al mecánico como al supervisor de mantenimiento.
     */
    public function tieneAccesoLimitadoAMantenimiento(): bool
    {
        return in_array($this->rol, ['mecanico', 'supervisor'], true);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'firma_pin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
