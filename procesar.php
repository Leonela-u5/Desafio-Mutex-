<?php
require('fpdf/fpdf.php');

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Generador de Archivos PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light">';

// Validar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombreArchivo'], $_POST['nombreUsuario'], $_POST['contenidoArchivo'])) {
    $nombreArchivo = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $_POST['nombreArchivo']);
    $nombreUsuario = htmlspecialchars($_POST['nombreUsuario'], ENT_QUOTES, 'UTF-8');
    $contenidoArchivo = htmlspecialchars($_POST['contenidoArchivo'], ENT_QUOTES, 'UTF-8');

    // Rutas de los archivos
    $rutaPdf = "results/{$nombreArchivo}.pdf";
    $rutaTxt = "results/{$nombreArchivo}.txt";
    $rutaQr = "results/{$nombreArchivo}_qr.png";

    // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, "Archivo generado por: {$nombreUsuario}", 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $contenidoArchivo);

    // Extraer metadatos
    $pdf->Ln(20);
    $metadatos = [
        "Nombre del archivo" => "{$nombreArchivo}.pdf",
        "Tamaño del archivo" => round(filesize($rutaPdf) / 1024, 2) . " KB",
        "Fecha de creación" => date("Y-m-d H:i:s", filectime($rutaPdf)),
        "Fecha de última modificación" => date("Y-m-d H:i:s", filemtime($rutaPdf)),
        "Autor" => $nombreUsuario,
        "Ruta del archivo" => realpath($rutaPdf)
    ];

    // Guardar metadatos en archivo TXT
    file_put_contents($rutaTxt, json_encode($metadatos, JSON_PRETTY_PRINT));

    // Generar QR con Python
    $comandoPython = escapeshellcmd("python3 generar_qr.py {$rutaTxt} {$rutaQr}");
    shell_exec($comandoPython);

    // Incluir el QR en el PDF
    if (file_exists($rutaQr)) {
        $pdf->Image($rutaQr, 10, $pdf->GetY(), 50);
    } else {
        $pdf->Cell(0, 10, "No se pudo generar el código QR", 0, 1, 'C');
    }

    // Guardar PDF
    $pdf->Output('F', $rutaPdf);

    // Mostrar enlaces de descarga
    echo "<div class='container mt-5'>
            <div class='card shadow-lg'>
                <div class='card-body'>
                    <h2 class='card-title text-center text-primary'>Archivo y Metadatos Generados</h2>
                    <p><strong>Nombre del archivo:</strong> {$nombreArchivo}.pdf</p>
                    <div class='d-flex gap-3'>
                        <a href='{$rutaPdf}' class='btn btn-success'>Descargar PDF</a>
                        <a href='{$rutaTxt}' class='btn btn-info'>Descargar TXT de Metadatos</a>
                    </div>
                    <div class='mt-4 text-center'>
                        <h4>Código QR generado:</h4>";
    if (file_exists($rutaQr)) {
        echo "<img src='{$rutaQr}' alt='Código QR' class='img-thumbnail' style='max-width: 200px;'/>";
    } else {
        echo "<p class='text-danger'>No se pudo generar el código QR.</p>";
    }
    echo "      </div>
                    <div class='mt-4 text-center'>
                        <a href=\"index.php\" class=\"btn btn-secondary\">Regresar</a>
                    </div>
                </div>
            </div>
          </div>";
} else {
    echo "<div class='container mt-5'>
            <div class='alert alert-danger' role='alert'>
                <h4 class='alert-heading'>Error</h4>
                <p>No se enviaron datos válidos. Por favor, vuelva a intentarlo.</p>
                <div class='text-center'>
                    <a href=\"index.html\" class=\"btn btn-secondary mt-3\">Regresar</a>
                </div>
            </div>
          </div>";
}

echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
?>
