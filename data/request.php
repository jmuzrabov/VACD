<?php
header('Content-Type: text/html; charset=utf-8');

echo '<h2>$_REQUEST</h2>';
echo '<pre>';
var_dump($_REQUEST);
echo '</pre>';

echo '<h2>$_GET</h2>';
echo '<pre>';
var_dump($_GET);
echo '</pre>';

echo '<h2>$_POST</h2>';
echo '<pre>';
var_dump($_POST);
echo '</pre>';

?>