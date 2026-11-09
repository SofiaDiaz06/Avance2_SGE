<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    // Auditoría (Clase 12)
    protected string $auditLog = 'categorias';

    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    // Relación: Category tiene muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}