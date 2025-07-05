// Service Worker for DAMS - Caching Strategy
const CACHE_NAME = 'dams-v1.0';
const urlsToCache = [
    '/',
    '/css/bootstrap.min.css',
    '/css/bootstrap-icons.css',
    '/css/owl.carousel.min.css',
    '/css/owl.theme.default.min.css',
    '/css/templatemo-medic-care.css',
    '/js/jquery.min.js',
    '/js/bootstrap.bundle.min.js',
    '/js/owl.carousel.min.js',
    '/js/scrollspy.min.js',
    '/js/custom.js',
    '/images/slider/portrait-successful-mid-adult-doctor-with-crossed-arms.jpg',
    '/images/slider/young-asian-female-dentist-white-coat-posing-clinic-equipment.jpg',
    '/images/slider/doctor-s-hand-holding-stethoscope-closeup.jpg'
];

// Install event - cache resources
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                // Return cached version or fetch from network
                return response || fetch(event.request);
            })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
}); 