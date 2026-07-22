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
        'direccion',
        'foto_perfil',
        'fecha_nacimiento',
        'fecha_ingreso',
        'correo_recuperacion',
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
     * ¿Es el coordinador de Recursos Humanos? Su único caso de uso es
     * gestionar Boletas (subir la boleta de pago de cada trabajador).
     */
    public function esRRHH(): bool
    {
        return $this->rol === 'rrhh';
    }

    /**
     * ¿Es de Logística Lima? Su único caso de uso es procesar los registros
     * ROP2026 LOTE IX (Logística) ya creados por administración: no puede
     * crearlos ni eliminarlos, solo completarlos y cambiarles el estado.
     */
    public function esLogistica(): bool
    {
        return $this->rol === 'logistica';
    }

    /**
     * ¿Puede ver el módulo de Mantenimiento (Reportes + Anomalías) en el menú?
     * Admin, mecánico y supervisor sí; RRHH no (no es su caso de uso).
     */
    public function puedeVerMantenimiento(): bool
    {
        return in_array($this->rol, ['admin', 'mecanico', 'supervisor'], true);
    }

    /**
     * ¿Tiene acceso completo a todos los módulos (Requerimientos, Control
     * Cartas, Logística, etc.)? Solo el rol "admin".
     */
    public function tieneAccesoCompleto(): bool
    {
        return $this->rol === 'admin';
    }

    /**
     * ¿Puede gestionar boletas de todos los trabajadores (subir/eliminar)?
     * RRHH y admin. El resto solo ve las suyas.
     */
    public function puedeGestionarBoletas(): bool
    {
        return $this->esRRHH() || $this->tieneAccesoCompleto();
    }

    /**
     * ¿Puede ver y gestionar únicamente las Cartas MAN (Mantenimiento) de
     * Control de Cartas? El supervisor de mantenimiento y admin.
     */
    public function puedeVerCartasMan(): bool
    {
        return $this->esSupervisorMantenimiento() || $this->tieneAccesoCompleto();
    }

    /**
     * ¿Es una cuenta autoregistrada que todavía no tiene rol asignado por
     * un administrador? No tiene acceso a ningún módulo de negocio.
     */
    public function esCuentaPendiente(): bool
    {
        return $this->rol === 'pendiente';
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
        'fecha_nacimiento' => 'date',
        'fecha_ingreso' => 'date',
        'last_login_at' => 'datetime',
    ];

    /**
     * Edad calculada a partir de la fecha de nacimiento (no se guarda en BD).
     */
    public function getEdadAttribute(): ?int
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->age : null;
    }
}
