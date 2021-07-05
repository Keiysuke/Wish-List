window.my_fetch = function (url, headers, datas){
    const csrf = headers.csrf ? {"X-CSRF-Token": document.head.querySelector("[name=csrf-token][content]").content} : {};
    return fetch(url, {
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            ...csrf
        },
        method: headers['method'],
        body: JSON.stringify(datas)
    });
}