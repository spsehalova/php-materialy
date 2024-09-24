<?php

function layout(string $title, callable $content): string
{
    ob_start();

    $content = $content();

    require __DIR__ . '/../views/layout.php';

    return ob_get_clean();
}

function str_before(string $haystack, string $needle): string
{
    $pos = strpos($haystack, $needle);

    return $pos === false ? $haystack : substr($haystack, 0, $pos);
}