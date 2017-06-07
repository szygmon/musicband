<?php
include('../../media/com_musicband/mpdf/vendor/autoload.php');

$contract = base64_decode(strtr($_POST['contract'], '-_,', '+/='));

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($contract);
$mpdf->Output();


