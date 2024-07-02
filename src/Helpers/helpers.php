<?php

if (!function_exists('modules_path')) {
    /**
     * Get the path to the modules directory.
     *
     * @param string $path
     * @return string
     */
    function modules_path(string $path = ''): string
    {
        return base_path('modules/' . $path);
    }
}
