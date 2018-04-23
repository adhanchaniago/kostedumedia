<?php

class Geoutil {

	function toGeoDec($deg, $min, $sec, $dir ){

		if(strtolower($dir) != 'u'||strtolower($dir) != 's'||strtolower($dir) != 't'||strtolower($dir) != 'b'||){
			throw new Exception('unrecognized direction symbol please use U or S for longitude and B or T for lattitude ');
		}

		$dec = $deg + ($min / 60.0) + ($sec / 3600.0) ;

		return $dec * $dir;
	}
	/*
		type = d/m/s/r
	*/
	function geoComponent($dec, $type, $lonOrLat){

		if(strtolower($type) == 'd'){
			return abs(floor($dec));
		}else if(strtolower($type) == 'm'){
			return floor( (abs($dec) - abs(floor($dec))) * 60 );
		}else if(strtolower($type) == 's'){
			$min = (abs($dec) - abs(floor($dec))) * 60;
			return floor ( (abs($min) - abs(floor($min))) * 60);
		}else if(strtolower($type) == 'r'){

			if($lonOrLat == 'lon'){
				if($dec < 0){
					return 'S';
				}else{
					return 'B';
				}
			}else if($lonOrLat == 'lat'){
				if($dec < 0){
					return 'T';
				}else{
					return 'B';
				}
			}else{
				throw new Exception("third parameter values must be 'lat' or 'lon'");
			}

		}else{
			throw new Exception("second parameter values must be 'd' for degree, 'm' for minutes , 's' for second and 'r' for direction ");
		}

		
	}
}