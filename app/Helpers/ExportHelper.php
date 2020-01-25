<?php

namespace App\Helpers;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ExportHelper {

	static public function requisitions( Collection $collection ) {
		$filename = self::getFilename( 'requisicoes' );

		return Excel::create( $filename, function ( $excel ) use ( $collection ) {
			$excel->sheet( 'sheetName', function ( $sheet ) use ( $collection ) {
				$data = array(
					'#',
					'Subgrupo',
					'Empenho',
					'Valor',
					'Data Compra',
					'Nr. Documento',
					'Descrição',
				);

				$sheet->row( 1, $data );
				$i = 2;
				foreach ( $collection as $dt ) {
					$sheet->row( $i, array(
						$dt->id,
						$dt->subgroup_name,
						$dt->plight_name,
						$dt->total_formatted,
						$dt->buy_at_formatted,
						$dt->document_number,
						$dt->main_descriptions
					) );
					$i ++;
				}
			} )->export( 'xls' );

		} );
	}

	static public function getFilename( $name = null ) {
		return ( ( $name != null ) ? $name . '_' : $name ) . 'export_' . Carbon::now()->format( 'd_m_Y-H_i' );
	}

	static public function products( Collection $collection ) {

		$filename = self::getFilename( 'produtos' );

		return Excel::create( $filename, function ( $excel ) use ( $collection ) {
			$excel->sheet( 'sheetName', function ( $sheet ) use ( $collection ) {
				$data = array(
					'#',
					'Código',
					'Nome',
					'Descrição'
				);

				$sheet->row( 1, $data );
				$i = 2;
				foreach ( $collection as $dt ) {
					$sheet->row( $i, array(
						$dt->id,
						$dt->code,
						$dt->name,
						$dt->description,
					) );
					$i ++;
				}
			} )->export( 'xls' );

		} );
	}

}
