<?php

spl_autoload_register(function ($class) {
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/classes/' . $class . '.php';
});

$database = new Database();
$villa = new Villas();
$options = new Eigenschappen();
$liggingsopties = new Liggingsopties();
$contact = new Contact();
$admin = new Admin();

Session::init();