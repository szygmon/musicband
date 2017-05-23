<?php
include('../../media/com_musicband/mpdf/vendor/autoload.php');

$contract = $_POST['contract'];

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($contract);
$mpdf->Output();


