const CACHE_NAME = 'v1_cache_miapp';
const urlsToCache = [
  '/',
  '/index.php',
  '/css/estilos.css',
  '/js/script.js',
  '/icon-192x192.png'
];

// Instalación: Almacena los archivos en caché
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
      .then(() => self.skipWaiting())
  );
});

// Estrategia: Responder con caché o buscar en red
self.addEventListener('fetch', e => {
  e.respondWith(
    caches.match(e.request).then(res => {
      return res || fetch(e.request);
    })
  );
});