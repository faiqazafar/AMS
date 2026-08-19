<?php

if ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '') {
    require __DIR__ . '/login.php';
    exit;
}

return false;