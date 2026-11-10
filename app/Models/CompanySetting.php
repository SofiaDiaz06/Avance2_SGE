<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Identidad corporativa (branding) del ERP. La tabla tiene una sola fila.
 * En las vistas está disponible como $branding (ver AppServiceProvider).
 */
class CompanySetting extends Model
{
    use Auditable;

    // Auditoría (Clase 12): los cambios de marca también quedan en la bitácora
    protected string $auditLog = 'branding';

    // Valores iniciales adaptados para Paraíso Distribuciones
    public const DEFAULTS = [
        'trade_name' => 'Paraíso Distribuciones',
        'legal_name' => 'Paraíso Distribuciones S.A.S.',
        'nit' => '901.234.567-8',
        'slogan' => 'Todo en papelería y suministros escolares',
        'address' => 'Calle 10 # 5-20',
        'city' => 'Cartago, Valle del Cauca',
        'phone' => '602 211 0000',
        'email' => 'ventas@paraisodistribuciones.test',
        'website' => null,
        'primary_color' => '#004e89', // Color azul corporativo acorde a tu preferencia de diseño
    ];

    protected $fillable = [
        'trade_name', 
        'legal_name', 
        'nit', 
        'slogan', 
        'address', 
        'city', 
        'phone', 
        'email', 
        'website', 
        'primary_color', 
        'logo_path',
    ];

    /**
     * La identidad corporativa vigente (se consulta una sola vez por petición).
     */
    public static function current(): self
    {
        return app('branding');
    }

    /**
     * Después de guardar cambios: la siguiente consulta vuelve a leer la base de datos.
     */
    public static function forget(): void
    {
        app()->forgetInstance('branding');
    }

    /**
     * URL pública del logo (requiere «php artisan storage:link»).
     */
    public function logoUrl(): ?string
    {
        return $this->logo_path ? asset('storage/'.$this->logo_path) : null;
    }

    /**
     * Ruta física del logo para DomPDF (los PDF no cargan imágenes por URL).
     */
    public function logoFilePath(): ?string
    {
        return $this->logo_path && Storage::disk('public')->exists($this->logo_path)
            ? Storage::disk('public')->path($this->logo_path)
            : null;
    }

    /**
     * Iniciales del nombre comercial: «Paraíso Distribuciones» → «PD».
     */
    public function initials(): string
    {
        return Str::of($this->trade_name)->explode(' ')->filter()->take(2)
            ->map(fn ($word) => Str::upper(Str::substr($word, 0, 1)))->implode('');
    }

    /**
     * Color de marca como «R G B» (formato que usan las variables CSS de Tailwind).
     * $mix < 0 oscurece el color y $mix > 0 lo aclara (mezcla con blanco).
     */
    public function brandRgb(float $mix = 0): string
    {
        $hex = ltrim($this->primary_color ?: self::DEFAULTS['primary_color'], '#');

        return collect(str_split($hex, 2))
            ->map(fn ($pair) => hexdec($pair))
            ->map(fn ($c) => $mix < 0 ? $c * (1 + $mix) : $c + (255 - $c) * $mix)
            ->map(fn ($c) => (int) round($c))
            ->implode(' ');
    }

    /**
     * Escala de tonos (50 a 950) generada a partir del color de marca. El tono 700 es el color exacto.
     * Reemplaza la paleta predeterminada para que el ERP adopte la marca corporativa.
     */
    public function brandScale(): array
    {
        $mixes = [
            50 => 0.93, 
            100 => 0.85, 
            200 => 0.72, 
            300 => 0.55, 
            400 => 0.38, 
            500 => 0.22,
            600 => 0.1, 
            700 => 0, 
            800 => -0.15, 
            900 => -0.3, 
            950 => -0.57
        ];

        return collect($mixes)->map(fn ($mix) => $this->brandRgb($mix))->all();
    }
}