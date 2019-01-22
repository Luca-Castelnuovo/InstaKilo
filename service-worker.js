self.addEventListener('install', function(event) {
    var offlinePage = new Request('offline.html');
    event.waitUntil(
        fetch(offlinePage)
        .then(function(response) {
            return caches.open('pwabuilder-offline')
                .then(function(cache) {
                    return cache.put(offlinePage, response);
                });
        }));
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        fetch(event.request)
        .catch(function(error) {
            return caches.open('pwabuilder-offline')
                .then(function(cache) {
                    return cache.match('offline.html');
                });
        }));
});

self.addEventListener('refreshOffline', function(response) {
    return caches.open('pwabuilder-offline')
        .then(function(cache) {
            return cache.put(offlinePage, response);
        });
});
