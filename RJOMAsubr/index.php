<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#ff74a4">
  <title>Sonic Elite </title>
  <link rel="apple-touch-icon" sizes="192x192"  href="icon.PNG"/>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="manifest" href="manifest.json">
  <style>
  /* Estilos para los inputs */
  /* Estilos para los inputs */
  input[type="file"] {
    display: none;
  }

  /* Estilos para los botones del formulario */
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
    font-size: 20px;
    color: #fff;
  }

  .submit-input::before {
    content: '✔';
  }

  /* Estilos para los botones de reproducción de música */
  .material-icons {
    font-size: 30px;
    color: #fff; /* Color inicial (morado) */
    cursor: pointer;
  }

  /* Ocultar el input de tipo submit */
  input[type="submit"] {
    display: none;
  }
  
.custom-input1 {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(var(--pink) 0%, var(--violet) 100%);
  cursor: pointer;
}

.custom-input1 input[type="file"] {
  display: none;
}

.custom-input1 .material-icons {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #fff;
  font-size: 24px;
  cursor: pointer;
}
.song-link {
  display: block;
  text-decoration: none;
  color: #333; /* Cambia el color del texto según tu preferencia */
  padding: 8px 12px; /* Ajusta el espaciado interno */
  margin-bottom: 6px; /* Espaciado entre elementos */
  border-radius: 4px; /* Bordes redondeados */
  transition: background-color 0.3s ease; /* Transición suave del color de fondo */
}

.song-link:hover {
  background-color: #f0f0f0; /* Cambia el color de fondo al pasar el cursor */
  color: #000; /* Cambia el color del texto al pasar el cursor */
}

</style>
</head>
<body>
  <div class="wrapper">
    <div class="top-bar">
      <i class="material-icons">expand_more</i>
      <span>Reproductor Majo</span>
      <i class="material-icons">more_horiz</i>
    </div>
    <div class="img-area">
      <img src="images/music-5.jpg" alt="">
    </div>
    <div class="song-details">
      
    </div>
    <div class="progress-area">
      <div class="progress-bar">
        <audio id="main-audio" src="songs/music-5.mp3"></audio>
      </div>
      <div class="song-timer">
        <span class="current-time">0:00</span>
        <span class="max-duration">2:48</span>
      </div>
    </div>
    <div class="controls">
      <i id="repeat-plist" class="material-icons" title="Playlist looped"></i>
      <i id="prev" class="material-icons"></i><button id="prevBtn"class="custom-input material-icons">skip_previous</button>
      <div class="play-pause">
        <i class="material-icons play">play_arrow</i>
      </div>
      <i id="next" class="material-icons"></i><button id="nextBtn" class="custom-input material-icons">skip_next</button>
      <i id="more-music" class="material-icons">queue_music</i>

  
<form action="upload.php" method="post" enctype="multipart/form-data">
  <!-- Input para "Agregar" -->
  <label for="mp3File" class="custom-input1" title="Agregar">
  <input type="file" name="mp3File" id="mp3File" accept=".mp3">
  <span class="material-icons">add</span>
</label>


  <!-- Input para "Subir MP3" -->
  <label for="submitBtn" class="custom-input submit-input" title="Subir MP3">
    <input type="submit" value="Subir MP3" name="submit" id="submitBtn">
  </label>
</form>

<!-- <i id="prevBtn" class="material-icons">skip_previous</i>
<i id="nextBtn" class="material-icons">skip_next</i> -->


    </div>
   <div class="music-list">
  <div class="header">
    <div class="row">
      <i class="list material-icons">queue_music</i>
      <span>Music list</span>
    </div>
    <i id="close" class="material-icons">close</i>
  </div>
  
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
</div>
    </div>
  </div>

    <script src="js/music-list.js"></script>
    <script src="js/script.js"></script>
    <script>
      if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('./Service_Worker.js')
      .then(registration => {
        console.log('Service Worker registrado con éxito:', registration);
      })
      .catch(error => {
        console.log('Error al registrar el Service Worker:', error);
      });
  }
const songLinks = document.querySelectorAll('.song-link');
    const audioPlayer = document.getElementById('audioPlayer');
let currentSongIndex = 0;
    let isPlaying = false;
    let isRandom = false;
  document.addEventListener('DOMContentLoaded', () => {
    fetch('songs')
      .then(response => {
        if (!response.ok) {
          throw new Error(`Network response was not ok: ${response.status}`);
        }
        return response.text();
      })
      .then(responseText => {
        const parser = new DOMParser();
        const htmlDocument = parser.parseFromString(responseText, 'text/html');
        
        const fileLinks = htmlDocument.querySelectorAll('a[href$=".mp3"]');
        const files = Array.from(fileLinks).map(link => link.textContent.trim());

        // Resto del código para procesar los archivos
        files.forEach((fileName, index) => {
          // Aquí puedes hacer algo con cada archivo si es necesario
          console.log(`Nombre del archivo ${index + 1}: ${fileName}`);
        });
      })
      .catch(error => {
        console.error('Error during fetch:', error);
      });

    const songLinks = document.querySelectorAll('.song-link');
    const audioPlayer = document.getElementById('audioPlayer');
let currentSongIndex = 0;
    let isPlaying = false;
    let isRandom = false;
    // Asignar un evento de clic a cada enlace de canción
    songLinks.forEach(link => {
      link.addEventListener('click', function(event) {
        event.preventDefault(); // Evitar comportamiento predeterminado del enlace

        const songSource = this.getAttribute('data-src');
        const audioPlayer = document.getElementById('main-audio');
        audioPlayer.src = songSource;
        audioPlayer.play();
      });
    });
  });
 function playSong(index) {
      const nextSong = songLinks[index].getAttribute('data-src');
      mainAudio.src = nextSong;
      mainAudio.play();
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
  



</body>
</html>
