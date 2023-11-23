<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Canciones</title>
</head>
<style type="text/css">
  body {
      font-family: 'Arial', sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    li {
      margin: 10px;
    }

    .song-link {
      text-decoration: none;
      color: #333;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      display: block;
      transition: background-color 0.3s ease;
    }

    .song-link:hover {
      background-color: #ddd;
    }

    #audioPlayer {
      width: 100%;
      margin-top: 20px;
    }
  /* Estilos para los botones circulares */
    button {
      background: linear-gradient(var(--pink) 0%, var(--violet) 100%);
      color: white;
      border: none;
      padding: 15px;
      margin: 10px;
      cursor: pointer;
      border-radius: 50%;
      font-size: 16px;
      width: 120px; /* Ancho ajustable */
      height: 120px; /* Alto ajustable */
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s ease;
      outline: none; /* Elimina el contorno al enfocar */
    }

    button:hover {
      background: linear-gradient(var(--violet) 0%, var(--pink) 100%);
    }

    .custom-input {
    display: inline-block;
    position: relative;
    border-radius: 50%;
    overflow: hidden;
    width: 40px;
    height: 40px;
background: linear-gradient(var(--pink) 0%, var(--violet) 100%);
    cursor: pointer;
    text-align: center;
    line-height: 40px; /* Centrar verticalmente el contenido */
  }

  /* Estilos para los íconos */
  .custom-input::before {
    content: '+';
    font-size: 20px;
    color: #fff;
  }

  .submit-input::before {
    content: '✔';
  }

  /* Estilos para los botones de reproducción de música */
  .material-icons {
    font-size: 24px;
    color: #8a2be2; /* Color inicial (morado) */
    cursor: pointer;
  }
</style>
<body>
  <h1>Lista de Canciones</h1>
  <ul>
    <?php
    $targetDirectory = "songs/"; // Directorio donde se guardan los archivos

    // Obtener todos los archivos de la carpeta de uploads
    $archivos = glob($targetDirectory . "*.{mp3}", GLOB_BRACE);

    // Mostrar cada archivo en la lista de canciones
    foreach ($archivos as $archivo) {
      echo "<li><a href='#' class='song-link' data-src='" . $archivo . "'>" . basename($archivo) . "</a></li>";
    }
    ?>
  </ul>

  <audio id="audioPlayer" controls>
    Tu navegador no soporta la etiqueta de audio.
  </audio>
<label class="custom-input">
  <button id="prevBtn">Anterior</button></label>
  <button id="nextBtn">Siguiente</button>
  <button id="playPauseBtn">Reproducir/Pausa</button>
  <button id="randomBtn">Aleatorio</button>

  <form action="upload.php" method="post" enctype="multipart/form-data">
    <!-- Input para "Agregar" -->
    <label for="mp3File" class="custom-input" title="Agregar">
      <input type="file" name="mp3File" id="mp3File" accept=".mp3">
    </label>

    <!-- Input para "Subir MP3" -->
    <label for="submitBtn" class="custom-input submit-input" title="Subir MP3">
      <input type="submit" value="Subir MP3" name="submit" id="submitBtn">
    </label>
  </form>

  <script>



    const songLinks = document.querySelectorAll('.song-link');
    const audioPlayer = document.getElementById('audioPlayer');
    let currentSongIndex = 0;
    let isPlaying = false;
    let isRandom = false;

    // Asignar un evento de clic a cada enlace de canción
    songLinks.forEach((link, index) => {
      link.addEventListener('click', function(event) {
        event.preventDefault(); // Evitar comportamiento predeterminado del enlace

        const songSource = this.getAttribute('data-src');
        audioPlayer.src = songSource;
        audioPlayer.play();

        currentSongIndex = index;
        isPlaying = true;
      });
    });





    // Botón Siguiente
    document.getElementById('nextBtn').addEventListener('click', function() {
      currentSongIndex = (currentSongIndex + 1) % songLinks.length;
      playSong(currentSongIndex);
    });

    // Botón Anterior
    document.getElementById('prevBtn').addEventListener('click', function() {
      currentSongIndex = (currentSongIndex - 1 + songLinks.length) % songLinks.length;
      playSong(currentSongIndex);
    });

    // Botón Reproducir/Pausa
    document.getElementById('playPauseBtn').addEventListener('click', function() {
      if (isPlaying) {
        audioPlayer.pause();
        isPlaying = false;
      } else {
        audioPlayer.play();
        isPlaying = true;
      }
    });

    // Botón Aleatorio
    document.getElementById('randomBtn').addEventListener('click', function() {
      isRandom = !isRandom;
      if (isRandom) {
        randomizeSongs();
      } else {
        resetSongOrder();
      }
    });

    // Función para reproducir una canción desde el índice dado
    function playSong(index) {
      const nextSong = songLinks[index].getAttribute('data-src');
      audioPlayer.src = nextSong;
      audioPlayer.play();
      isPlaying = true;
    }



   document.getElementById('nextBtn').addEventListener('click', function() {
  currentSongIndex = (currentSongIndex + 1) % songLinks.length;
  playSong(currentSongIndex);
});

document.getElementById('prevBtn').addEventListener('click', function() {
  currentSongIndex = (currentSongIndex - 1 + songLinks.length) % songLinks.length;
  playSong(currentSongIndex);
});


  </script>

  <i id="prevBtn" class="material-icons">skip_previous</i>
<i id="nextBtn" class="material-icons">skip_next</i>


</body>
</html>
