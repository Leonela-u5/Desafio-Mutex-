<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Archivos PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Generador de Archivos PDF</h1>
    <form action="procesar.php" method="post">
        <!-- Campo para el nombre del archivo -->
        <div class="mb-3">
            <label for="nombreArchivo" class="form-label">Nombre del archivo (sin extensión)</label>
            <input type="text" class="form-control" id="nombreArchivo" name="nombreArchivo" placeholder="Ejemplo: documento" required>
        </div>

        <!-- Campo para el nombre del usuario -->
        <div class="mb-3">
            <label for="nombreUsuario" class="form-label">Nombre del usuario</label>
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Ejemplo: Juan Pérez" required>
        </div>

        <!-- Campo para el contenido del archivo -->
        <div class="mb-3">
            <label for="contenidoArchivo" class="form-label">Contenido del archivo</label>
            <textarea class="form-control" id="contenidoArchivo" name="contenidoArchivo" rows="5" placeholder="Ingrese el contenido para el archivo PDF..." required></textarea>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Generar PDF y Metadatos</button>
    </form>
</div>
</body>
</html>
