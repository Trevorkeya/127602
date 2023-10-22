<?php

namespace App\Helpers;

// app/helpers.php

if (!function_exists('generateTwoFactorCode')) 
{
    function generateTwoFactorCode()
    {
        return rand(1000, 9999);
    }
}

