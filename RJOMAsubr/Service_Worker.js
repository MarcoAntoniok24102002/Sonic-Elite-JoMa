const CACHE_NAME = 'my-cache-v1';
const FONT_URL = 'https://fonts.googleapis.com/icon?family=Material+Icons';

const urlsToCache = [
  '/',
  '/index.html',
  '/path/to/icon.png',
  '/js/music-list.js',
  '/js/script.js',
  '/style.css',
  '/upload.php',
  
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
      .catch(error => {
        console.error('Error durante la instalación del Service Worker:', error);
        // Puedes agregar acciones adicionales o mensajes aquí según tu necesidad.
      })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.open('cacheName').then(cache => {
      return fetch(event.request).then(response => {
        // Solo almacenar en caché respuestas completas (código 200)
        if (response.status === 200) {
          const clonedResponse = response.clone();
          cache.put(event.request, clonedResponse);
        }
        return response;
      }).catch(error => {
        // Manejar errores de red u otras respuestas parciales
        return cache.match(event.request);
      });
    })
  );
});
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.open('cacheName').then(cache => {
      return fetch(event.request).then(response => {
        // Solo almacenar en caché respuestas completas (código 200)
        if (response.status === 200) {
          const clonedResponse = response.clone();
          cache.put(event.request, clonedResponse);
        }
        return response;
      }).catch(error => {
        // Manejar errores de red u otras respuestas parciales
        return cache.match(event.request);
      });
    })
  );
});