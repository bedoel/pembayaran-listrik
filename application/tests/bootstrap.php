<?php
// Muat CodeIgniter
require dirname(__DIR__) . '/../../index.php';

// Inisialisasi CodeIgniter untuk pengujian
$CI = &get_instance();
$CI->load->database();
$CI->load->library('unit_test');
$CI->load->library('session');

// Pastikan CodeIgniter berada dalam mode testing
define('ENVIRONMENT', 'testing');
