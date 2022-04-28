<?php
ini_set('default_charset', '');
mb_http_output('pass');
mb_detect_order(["UTF-8"]);

require 'upload.php';

$fi="uploads/studentdb.xlsx";
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile("uploads/studentdb.xlsx");


$request_method = $_SERVER["REQUEST_METHOD"];


if ($request_method == 'GET') {
    global $reader;
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load("uploads/studentdb.xlsx");
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();
    $highestColumn = $worksheet->getHighestColumn();
    $highestColumnIndex = PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

    $data = array();

    for ($row = 1; $row <= $highestRow; $row++) {
        $riga = array();
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $riga[] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
        if (1 === $row) {
            // Header row. Save it in "$keys".
            $keys = $riga;
            continue;
        }
        // This is not the first row; so it is a data row.
        // Transform $riga into a dictionary and add it to $data.
        $data[] = array_combine($keys, $riga);
    }
            
     echo json_encode($data);    

}
    
?>