let allMusic = []; // Tu lista de canciones

// Supongamos que tienes algunas canciones predefinidas
// Esto es solo un ejemplo inicial, puede estar vacío al principio
const initialSongs = [
  // {
  //   name: "Song 1",
  //   artist: "Artist 1",
  //   img: "music-1",
  //   src: "music-1"
  // },
  // {
  //   name: "Song 2",
  //   artist: "Artist 2",
  //   img: "music-2",
  //   src: "music-2"
  // }
];

allMusic = allMusic.concat(initialSongs);

function handleFileUpload() {
  const fileInput = document.getElementById('fileInput');
  const files = fileInput.files;
  let newSongs = [];

  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const songObject = {
      name: file.name.replace('.mp3', ''),
      artist: 'Unknown',
      img: `music-${i + 1}`,
      src: file.name.replace('.mp3', '')
    };
    newSongs.push(songObject);
  }

  allMusic = allMusic.concat(newSongs);
  console.log(allMusic); // Esto imprime la lista actualizada en la consola
}
