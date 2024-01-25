<?php

// Mendapatkan protokol (http atau https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

// Mendapatkan nama host (domain)
$host = $_SERVER['HTTP_HOST'];

// Mendapatkan direktori proyek
$directory = rtrim(dirname($_SERVER['PHP_SELF']), '/');

// Membuat variabel URL global
define('BASE_URL', "$protocol://$host$directory");

$hostname = 'localhost';
$database = 'gege_db';
$username = 'root';
$password = '';

