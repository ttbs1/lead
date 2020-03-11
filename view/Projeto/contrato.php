

<?php
                    
use Dompdf\Dompdf;
include_once '../../util/dompdf/autoload.inc.php';

$valor = 0;
if(!empty($_POST)) {
    $cliente = $_POST['contrato_cliente'];
    $valor = $_POST['contrato_valor'];
}

$html = "valor: ". $valor ." cliente: ". $cliente;

$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream(
            "contrato.pdf",
            array(
                "Attachment" => false
            )
        );

?>