<?php

use App\Models\CompanySetting;
use App\Models\Module;

if (! function_exists('is_module_active')) {
    /**
     * Verifica si un módulo específico se encuentra activo.
     */
    function is_module_active(string $moduleKey): bool
    {
        return Module::isActive($moduleKey);
    }
}

if (! function_exists('company_setting')) {
    /**
     * Obtiene una configuración global de la empresa.
     *
     * @param  mixed  $default
     * @return mixed
     */
    function company_setting(string $key, $default = null)
    {
        return CompanySetting::get($key, $default);
    }
}
