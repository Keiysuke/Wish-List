window.notyfJS = function (msg, kind){
    let notyf = new Notyf();
    notyf[kind]({
        'position': {
            'x': 'right',
            'y': 'top',
        },
        'message': msg,
        'duration': 3000,
        'dismissible': true,
    });
}

window.my_notyf = function (r){
    if (r.notyf) {
        var notyf = new Notyf();
        notyf.open(r.notyf);
    }
}