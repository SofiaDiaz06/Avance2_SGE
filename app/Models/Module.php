<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'is_active',
    ];

    /**
     * Consulta si un módulo específico se encuentra activo.
     * 
     * @param string $key
     * @return bool
     */
    public static function isActive(string $key): bool
    {
        return self::where('key', $key)->value('is_active') ?? false;
    }
}