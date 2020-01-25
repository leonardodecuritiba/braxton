<?php

namespace App\Helpers;

use Carbon\Carbon;
use Jenssegers\Date\Date;

class DataHelper {
	// ******************** FUNCTIONS ******************************
	static public function getTimestamp( $value ) {
		return strtotime( $value );
	}

	static public function now() {
		return Date::now()->format( 'H:i - d/m/Y' );
	}

	static public function getPercent2Float( $value ) {
		return floatval( str_replace( ',', '.', $value ) );
	}

	static public function getReal2Float( $value ) {
		return ( ( $value == '' ) || ( $value == null ) ) ? 0 : floatval( str_replace( ',', '.', str_replace( '.', '', $value ) ) );
	}

	static public function getFloat2Currency( $value ) {
		return 'R$ ' . self::getFloat2Real( $value );
	}

	static public function getFloat2Real( $value ) {
		return number_format( $value, 2, ',', '.' );
	}

	static public function getFullPrettyDateTime( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d H:i:s', $value )->format( 'd/m/Y H:i:s' ) : $value;
	}

	static public function getPrettyDateTime( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d H:i:s', $value )->format( 'H:i - d/m/Y' ) : $value;
	}

	static public function getPrettyDateTimeToMonth( $value ) {
		Date::setLocale( 'pt_BR' );

		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d H:i:s', $value )->format( 'F/Y' ) : $value;
	}

	static public function getPrettyDate( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'Y-m-d', $value )->format( 'd/m/Y' ) : $value;
	}

	static public function getPrettyToCorrectDate( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'd/m/Y', $value )->format( 'Y-m-d' ) : $value;
	}

	static public function getPrettyToCorrectDateTime( $value ) {
		return ( $value != null ) ? Date::createFromFormat( 'd/m/Y', $value )->format( 'Y-m-d H:i:s' ) : $value;
	}

	static public function setDate( $value ) {
		return ( ( $value != null ) && ( $value != '' ) ) ? Date::createFromFormat( 'dmY', self::getOnlyNumbers( $value ) )->format( 'Y-m-d' ) : null;
	}

	static public function getOnlyNumbers( $value ) {
		return ( $value != null ) ? preg_replace( "/[^0-9]/", "", $value ) : $value;
	}

	static public function getOnlyValues( $value ) {
		return ( $value != null ) ? preg_replace( "/[^0-9-.-,]/", "", $value ) : $value;
	}

	static public function getOnlyNumbersLetters( $value ) {
		return ( $value != null ) ? preg_replace( "/[^a-zA-Z0-9-]/", "", $value ) : $value;
	}

	static public function getShortName( $value ) {
		$value = explode( ' ', $value );

		return ( count( $value ) > 1 ) ? ( $value[0] . " " . end( $value ) ) : $value[0];
	}

	static public function mask( $val, $mask ) {
		if ( $val != null || $val != "" ) {
			$maskared = '';
			$k        = 0;
			for ( $i = 0; $i <= strlen( $mask ) - 1; $i ++ ) {
				if ( $mask[ $i ] == '#' ) {
					if ( isset( $val[ $k ] ) ) {
						$maskared .= $val[ $k ++ ];
					}
				} else {
					if ( isset( $mask[ $i ] ) ) {
						$maskared .= $mask[ $i ];
					}
				}
			}
		} else {
			$maskared = null;
		}

		return $maskared;
	}

	static public function generateDateRange(Carbon $start, Carbon $end)
	{
		$weekMap = [
			0 => 'Domingo',
			1 => 'MO',
			2 => 'TU',
			3 => 'WE',
			4 => 'TH',
			5 => 'FR',
			6 => 'SA',
		];
		$dayOfTheWeek = Carbon::now()->dayOfWeek;
		$weekday = $weekMap[$dayOfTheWeek];
		$dates = [];
		for($date = $start; $date->lte($end); $date->addDay()) {
			$dates[] = $date->format('Y-m-d');
		}

		return $dates;
	}

}
