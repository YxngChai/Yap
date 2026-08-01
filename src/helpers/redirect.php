<?php


function redirectBack(string $default = '/yap/public/') :never {
    $redirect = $_POST['redirect'] ?? $default;

    if (
        !str_starts_with($redirect, '/') ||
        str_starts_with($redirect, '//')) 
        {
            $redirect = $default;
        }
    header("Location: $redirect");
    exit;
}