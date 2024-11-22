<?php
if (isset($_GET['archivo'])) {
    $archivo = $_GET['archivo'];
    $ruta = "results/" . basename($archivo);

    if (file_exists($ruta)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($ruta) . '"');
        header('Content-Length: ' . filesize($ruta));
        readfile($ruta);
        exit;
    } else {
        echo "El archivo solicitado no existe.";
    }
} else {
    echo "No se especificó un archivo para descargar.";
}
?>
