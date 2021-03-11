const SHOW_ERRORS = 1;

module.exports = {
    msg: function (res, code, txt, err) {
        //The code is an error if it's different to 2xx
        if (String(code).charAt(0) != '2') txt = { 'error': txt };

        //We may show the catched errors
        if (SHOW_ERRORS && err != undefined) txt['catched_error'] = '' + err;
        res.status(code).json(txt);
    }
}