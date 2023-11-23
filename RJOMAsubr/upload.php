<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["mp3File"])) {
    $targetDir = "songs/"; // Directorio donde se guardarán los archivos
    $targetFile = $targetDir . basename($_FILES["mp3File"]["name"]);
    $uploadOk = 1;
    $mp3FileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Verificar si el archivo es un archivo MP3 válido
    if ($mp3FileType != "mp3") {
        echo "Solo se permiten archivos MP3.";
        $uploadOk = 0;
    }

    // Verificar si el archivo ya existe
    if (file_exists($targetFile)) {
        echo "El archivo ya existe.";
        $uploadOk = 0;
    }

    // Verificar tamaño del archivo (opcional)
    if ($_FILES["mp3File"]["size"] > 5000000000) { // 5MB
        echo "El archivo es demasiado grande.";
        $uploadOk = 0;
    }

    // Si no hay problemas, intentar subir el archivo
    if ($uploadOk == 0) {
        echo "No se pudo subir el archivo.";
    } else {
        if (move_uploaded_file($_FILES["mp3File"]["tmp_name"], $targetFile)) {
            echo "El archivo ". htmlspecialchars(basename($_FILES["mp3File"]["name"])). " ha sido subido.";
             // header("Location: index.php");
        } else {
            echo "Hubo un error al subir el archivo.";
             // header("Location: index.php");
        }
    }
} else {
    echo "Acceso no permitido.";
     // header("Location: index.php");
}
?>
