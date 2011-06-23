<?php
require_once('fpdf17/fpdf.php');
require_once('fpdi-1.4.1/fpdi.php');

class concat_pdf extends fpdi {
	var $files = array();

	function concat_pdf($orientation='P',$unit='mm',$format='A4') {
		parent::fpdi($orientation,$unit,$format);
	}

	function setFiles($files) {
		$this->files = $files;     
	}

	function concat() {
		foreach($this->files AS $file) {
			$pagecount = $this->setSourceFile($file);
			for ($i = 1; $i <= $pagecount; $i++) {
				$tplidx = $this->ImportPage($i);$this->AddPage();
				$this->useTemplate($tplidx);
			}
		}
	}
}

$files = array();
foreach ($_GET as $file) {
	array_push(&$files, "uploads/{$file}");
}

$pdf= new concat_pdf();
$pdf->setFiles($files);
$pdf->concat();
$filename = rand();
$pdf->Output("downloads/{$filename}.pdf","F");
echo "Ready, Download <a href=\"http://pdfmerger.bad-science.net/downloads/{$filename}.pdf\">this</a>";
?>
