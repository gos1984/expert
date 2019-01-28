<?php
namespace app\other;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class XLS {
	private $title;
	private $data;
	private $xls;
	private $sheet;

	public function __construct($title, $data) {
		$this->sheet = new Spreadsheet();
		$this->title = $title;
		$this->data = $data;
	}
	function getFile($name = 'file') {
		$activeSheet = $this->sheet->getActiveSheet();
		$activeSheet->setTitle($name);
		$i = 1;

		foreach($this->title as $keyRow => $valRow) {
			
			$activeSheet->setCellValueByColumnAndRow($i, 1, $valRow);

			for($j = 0; $j < count($this->data); $j++) {
				$rowCell = $j + 2;
				$activeSheet->setCellValueByColumnAndRow($i,$rowCell,$this->data[$j][$keyRow]);
			}
			$i++;
		}

		
	}

	function __destruct() {
		header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
		header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
		header ( "Cache-Control: no-cache, must-revalidate" );
		header ( "Pragma: no-cache" );
		header ( "Content-type: application/vnd.ms-excel" );
		header ( "Content-Disposition: attachment; filename=results.xls" );
		$objWriter = new Xlsx($this->sheet);
		$objWriter->save('php://output');
	}

}

?>