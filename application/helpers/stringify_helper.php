<?php
	
	function iff($cond, $printiftrue, $printiffalse){
		if($cond)
			echo $printiftrue;
		else
			echo $printiffalse;
	}