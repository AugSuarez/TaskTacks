<?php
function view($view, $datos=[]) {
	extract($datos);
	include '../views/' .$view. '.php';
}