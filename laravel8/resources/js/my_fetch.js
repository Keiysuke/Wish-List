window.myFetch = function (url, headers, datas){
    // Récupère le token CSRF de façon robuste : meta[name=csrf-token] ou cookie XSRF-TOKEN
    let csrfToken = null;
    if (headers.csrf) {
        const meta = document.querySelector('meta[name="csrf-token"]');
        if (meta && meta.getAttribute('content')) {
            csrfToken = meta.getAttribute('content');
        } else {
            // fallback: chercher le cookie XSRF-TOKEN
            const match = document.cookie.match(new RegExp('(^|; )XSRF-TOKEN=([^;]+)'));
            if (match) csrfToken = decodeURIComponent(match[2]);
        }
    }

    const csrfHeader = headers.csrf && csrfToken ? {"X-CSRF-Token": csrfToken} : {};
    if (headers.csrf && !csrfToken) console.warn('CSRF token not found in meta or cookie; request may be rejected.');

    return fetch(url, {
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            ...csrfHeader
        },
        method: headers['method'],
        body: JSON.stringify(datas)
    })
}

window.getFetch = function (url){
    return fetch('http://localhost/00%20-%20API/products-managing/laravel8/public/' + url, {
        headers: {"X-Requested-With": "XMLHttpRequest"},
        method: 'get'
    }).then(response => {
        if (response.ok) return response.json()
    })
}