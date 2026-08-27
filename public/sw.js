const CACHE = 'sajian-v1';
const OFFLINE = '/offline.html';
const PRECACHE = [OFFLINE, '/logo.svg', '/icons/icon-192.png', '/icons/icon-512.png'];

self.addEventListener('install', (e) => {
    e.waitUntil(caches.open(CACHE).then((c) => c.addAll(PRECACHE)).then(() => self.skipWaiting()));
});

self.addEventListener('activate', (e) => {
    e.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(keys.filter((k) => k !== CACHE).map((k) => caches.delete(k))))
            .then(() => self.clients.claim())
    );
});

// Halaman tidak pernah di-cache: menu, harga dan keranjang harus selalu segar.
// Yang di-cache hanya aset statis (build vite, ikon, font).
const isAsset = (url) =>
    url.pathname.startsWith('/build/') ||
    url.pathname.startsWith('/icons/') ||
    url.pathname.startsWith('/assets/') ||
    /\.(css|js|png|jpe?g|svg|webp|woff2?|ttf)$/i.test(url.pathname);

self.addEventListener('fetch', (e) => {
    const url = new URL(e.request.url);
    if (e.request.method !== 'GET' || url.origin !== self.location.origin) return;

    if (e.request.mode === 'navigate') {
        e.respondWith(fetch(e.request).catch(() => caches.match(OFFLINE)));
        return;
    }

    if (!isAsset(url)) return;

    e.respondWith(
        caches.match(e.request).then((hit) =>
            hit || fetch(e.request).then((res) => {
                if (res.ok) {
                    const copy = res.clone();
                    caches.open(CACHE).then((c) => c.put(e.request, copy));
                }
                return res;
            })
        )
    );
});
