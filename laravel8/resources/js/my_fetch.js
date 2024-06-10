window.myFetch = function (url, headers, datas){
    const csrf = headers.csrf ? {"X-CSRF-Token": document.head.querySelector("[name=csrf-token][content]").content} : {}
    return fetch(url, {
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            ...csrf
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