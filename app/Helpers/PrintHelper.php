<?php

namespace App\Helpers;

use App\Models\Clients\Reports\Report;
use App\Models\Clients\Reports\ReportLog;
use Carbon\Carbon;
use \Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class PrintHelper {


	static public function reportLogExport( ReportLog $report_log ) {
		$data = $report_log->data;
		$report = $report_log->report;

		$user     = Auth::user();
		$filename = self::getFilename( 'report_' . $report_log->id );
		$options  = [
			'filename'  => $filename,
			'Report'    => $report->getMapList(),
			'User'      => $user,
			'Data'      => $data,
//			'Data'        => DataHelper::now(),
		];


		return view('pages.reports.report', $options);

		$pdf = PDF::loadView( 'pages.reports.report', $options );
		$pdf->getDomPDF()->set_option( "enable_php", true );

		return $pdf->stream( $filename );
	}


	static public function reportExport( Report $report ) {
		$data = $report->run();

		$user     = Auth::user();
		$filename = self::getFilename( 'report_' . $report->id );
		$options  = [
			'filename'  => $filename,
			'Report'    => $report->getMapList(),
			'User'      => $user,
			'Data'      => $data,
//			'Data'        => DataHelper::now(),
		];

		return view('pages.reports.report', $options);

		$pdf = PDF::loadView( 'pages.reports.report', $options );
		$pdf->getDomPDF()->set_option( "enable_php", true );

		return $pdf->stream( $filename );
	}

	// ******************** FUNCTIONS ******************************

	static public function getFilename( $name = null ) {
		return ( ( $name != null ) ? $name . '_' : $name ) . 'print_' . Carbon::now()->format( 'd_m_Y-H_i' ) . '.pdf';
	}

}
