<?php
include('../../media/com_musicband/mpdf/mpdf.php');

$inputs = $_POST;
$contract = $inputs['contract'];
unset($inputs['send']);
unset($inputs['contract']);

foreach ($inputs as $name => $value) {
    $contract = str_replace('{' . $name . '}', $value, $contract);
}

$mpdf = new mPDF();
$mpdf->WriteHTML($contract);
$mpdf->Output();


