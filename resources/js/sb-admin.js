/*!
    * Start Bootstrap - SB Admin v7.0.4 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2021 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */

const { isArguments } = require("lodash");

    //
// Scripts
//

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
    showRedStarRequired();
});

window.showRedStarRequired = () => {
    let formControlElements = $('.form-control');
    jQuery.each(formControlElements, (index, element) => {
        if ($(element).prop('required')) {
            let label = $(`label[for='${element.id}']`);
            if (label) {
                label.append(`<span class="text-danger">*</span>`);
            }
        }
    });
}

window.showErrorField = (errors) => {
    Object.keys(errors).forEach(key => {
        let errorField = $(`#${key}_error_field`);
        if (errorField) {
            errorField.html(errors[key].join(' | '));
            errorField.removeClass('d-none');
        }
    });
}

window.clearErrorField = () => {
    $('.error-field').each(el => {
        $(el).html('');
        $(el).addClass('d-none');
    });
}

window.activateTooltip = () => {
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
}
