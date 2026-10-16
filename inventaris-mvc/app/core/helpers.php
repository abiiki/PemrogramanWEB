<?php
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function rupiah($value): string
{
    return 'Rp ' . number_format((float)$value, 0, ',', '.');
}
function base_url(string $path = ''): string
{
    return BASEURL . '/' . ltrim($path, '/');
}
function take_flash(): ?array
{
    if (empty($_SESSION['flash']))
        return null;
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}
