<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Database;
use App\Auth;

$email = $_POST['email'];
$senha = $_POST['senha'];

if(!$email || !$senha){
    echo "Preencha o e-mail e a senha";
}

try{
    $db = new Database();
    $auth= new Auth($db);

if($auth->login($email, $senha)){
    header('location: painel.php');
}else{
    echo "Email ou senha invalidos";
}

}catch(Exception $e){
    echo "Erro " . $e->getMessae();
}