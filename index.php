<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Archivos PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PDF Generator</a>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container mt-5 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg" style="width: 100%; max-width: 600px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4 text-primary">Generador de Archivos PDF</h2>
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
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Generar PDF y Metadatos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="text-center mt-5">
        <p class="text-muted">&copy; 2024 Generador de PDF</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
