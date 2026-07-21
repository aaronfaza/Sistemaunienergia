<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetCode extends Model
{
    protected $fillable = [
        'user_id',
        'codigo',
        'expira_en',
        'usado_en',
    ];

    protected $casts = [
        'expira_en' => 'datetime',
        'usado_en' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estaVigente(): bool
    {
        return is_null($this->usado_en) && $this->expira_en->isFuture();
    }
}
