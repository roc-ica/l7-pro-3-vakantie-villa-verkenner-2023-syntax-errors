<?php

spl_autoload_register(function ($class) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/classes/' . $class . '.php';
});

Session::init();

$database = new Database();
$villa = new Villas();
$options = new Eigenschappen();
$liggingsopties = new Liggingsopties();

$admin = new Admin();