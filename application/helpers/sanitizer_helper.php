<?php

function no_whitespace($str){
	return preg_replace("/[\w]+/", "_", trim($str));
}