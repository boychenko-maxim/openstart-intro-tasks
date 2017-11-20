<?php

function getAbsoluteUrl(string $path)
{
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    return "http://$host$uri/$path";
}