<?php
require('fpdf/fpdf.php');

// Validar si se enviaron datos desde el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombreArchivo'], $_POST['nombreUsuario'], $_POST['contenidoArchivo'])) {
    $nombreArchivo = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $_POST['nombreArchivo']); // Sanitizar nombre
    $nombreUsuario = htmlspecialchars($_POST['nombreUsuario'], ENT_QUOTES, 'UTF-8');
    $contenidoArchivo = htmlspecialchars($_POST['contenidoArchivo'], ENT_QUOTES, 'UTF-8');

    // Ruta de almacenamiento
    $rutaPdf = "results/{$nombreArchivo}.pdf";
    $rutaTxt = "results/{$nombreArchivo}.txt";

    // Crear el archivo PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, "Archivo generado por: {$nombreUsuario}", 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $contenidoArchivo);
    $pdf->Output('F', $rutaPdf);

    // Extraer metadatos
    $fechaCreacion = filectime($rutaPdf) ? date("Y-m-d H:i:s", filectime($rutaPdf)) : "No disponible";
    $fechaModificacion = filemtime($rutaPdf) ? date("Y-m-d H:i:s", filemtime($rutaPdf)) : "No disponible";

    $metadatos = [
        "Nombre del archivo" => "{$nombreArchivo}.pdf",
        "Tamaño del archivo" => round(filesize($rutaPdf) / 1024, 2) . " KB",
        "Fecha de creación" => $fechaCreacion,
        "Fecha de última modificación" => $fechaModificacion,
        "Autor" => $nombreUsuario,
        "Ruta del archivo" => realpath($rutaPdf)
    ];

    // Guardar metadatos en archivo TXT
    file_put_contents($rutaTxt, json_encode($metadatos, JSON_PRETTY_PRINT));

    // Mostrar enlaces de descarga
    echo "<div class='container mt-5'>
            <h2>Archivo y Metadatos Generados</h2>
            <p><strong>Nombre del archivo:</strong> {$nombreArchivo}.pdf</p>
            <a href='{$rutaPdf}' class='btn btn-success'>Descargar PDF</a>
            <a href='{$rutaTxt}' class='btn btn-info'>Descargar TXT de Metadatos</a>
          </div>";
} else {
    echo "<div class='container mt-5'><h2>Error</h2><p>No se enviaron datos válidos.</p></div>";
}
?>
