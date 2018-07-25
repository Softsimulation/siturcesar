let version = '1.0';

self.addEventListener('install', e => {
    let timeStamp = Date.now();
    e.waitUntil(
      caches.open('siturMagdalena').then(cache => {
          return cache.addAll([
            `res/img/brand/default.png?timestamp=${timeStamp}`,
            `res/img/brand/banner.png?timestamp=${timeStamp}`,
            `res/img/brand/others/logo_cotelco.png?timestamp=${timeStamp}`,
            `res/img/brand/others/logo_fontur.png?timestamp=${timeStamp}`,
            `res/img/brand/others/logo_gobierno.png?timestamp=${timeStamp}`,
            `res/img/brand/others/logo_mincit.png?timestamp=${timeStamp}`,
            `res/img/icons/sprite-stats.png?timestamp=${timeStamp}`
          ])
          .then(() => self.skipWaiting());
      })
    )
});

self.addEventListener('activate',  event => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
    event.respondWith(
      caches.match(event.request, {ignoreSearch:true}).then(response => {
          return response || fetch(event.request);
      })
    );
});