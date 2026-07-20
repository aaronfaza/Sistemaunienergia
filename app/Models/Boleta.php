<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'periodo',
        'archivo',
        'subido_por',
    ];

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
