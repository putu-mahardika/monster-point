window._ = require('lodash');
window.Popper = require("@popperjs/core").default;
window.$ = window.jQuery = require("jquery");
require("bootstrap");
require("devextreme/dist/js/dx.all");
window.Swal = require("sweetalert2");
window.Toats = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

require('select2');
require('ace-builds');

