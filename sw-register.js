if (!navigator.serviceWorker.controller) {
    navigator.serviceWorker.register('service-worker.js', {
        scope: './'
    })
}
