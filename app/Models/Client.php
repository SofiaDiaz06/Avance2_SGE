<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_type',
        'document_number',
        'name',
        'email',
        'phone',
        'address',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    // Relación: un cliente tiene muchas ventas[cite: 56]
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}