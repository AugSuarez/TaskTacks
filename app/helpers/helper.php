<?php
function view($view, $datos=[]) {
	extract($datos);
	include $_SERVER['DOCUMENT_ROOT'] . '/views/' .$view. '.php';
}