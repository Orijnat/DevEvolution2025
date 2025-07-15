<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Database;

try {
    $db = new Database();
    echo " Banco de dados criados com sucesso!";
} catch (Exception $e) {
    echo " Erro: " . $e->getMessage();
}
