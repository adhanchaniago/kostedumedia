<?php
/*
		type = d/m/s/r
	*/

	function toGeoDec($deg, $min, $sec, $dir ){

		$dec = $deg + ( (float) $min / 60.0) + ((float) $sec / 3600.0) ;

		return $dec * $dir;
	}

	function geoComponent($d, $type, $latlon = null){

		

		$coord = (float) $d;
		if(strtolower($type) == 'd'){
			return floor(abs($coord));
		}else if(strtolower($type) == 'm'){

			$deg = floor(abs($coord));
	  		$coord = (abs($coord)-$deg)*60;
	  		return floor($coord);

		}else if(strtolower($type) == 's'){

			$deg = floor(abs($coord));
	  		$coord = (abs($coord)-$deg)*60;
	  		$min = floor($coord);
			return round(($coord-$min)*60);

		}else if(strtolower($type) == 'r'){
			if($coord < 0){
				return -1;
			}else{
				return 1;
			}
		}else if(strtolower($type) == 'a'){
			
			$r = null;
			$deg = geoComponent($d,'d');
			$min = geoComponent($d,'m');
			$sec = geoComponent($d,'s');
			

			if($latlon == 'lat'){
				$r = ($d > 0)?'U':'S';
			}else{
				$r = ($d > 0)?'T':'B';
			}

			return $deg.'&deg;'.$min.'\''.$sec.'&quot;'.$r;
		}else{
			throw new Exception("second parameter values must be 'd' for degree, 'm' for minutes , 's' for second and 'r' for direction ");
		}

		
	}