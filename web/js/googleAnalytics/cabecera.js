$("#eventRadio").on("click", function () {
    ga('send', 'event', {
        eventCategory: 'Click Radio',
        eventAction: 'click',
        eventLabel: 'Click en el botón de la radio'
    });
});


$("#eventRegistrarse").on("click", function () {
    ga('send', 'event', {
        eventCategory: 'Click Registro',
        eventAction: 'click',
        eventLabel: 'Click en el botón de registrarse'
    });
});


$("#eventRadioMovil").on("click", function () {
    ga('send', 'event', {
        eventCategory: 'Click Radio',
        eventAction: 'click',
        eventLabel: 'Click en el botón de la radio menu movil'
    });
});


$("#eventRegistrarseMovil").on("click", function () {
    ga('send', 'event', {
        eventCategory: 'Click Registro',
        eventAction: 'click',
        eventLabel: 'Click en el botón de registrarse menu movil'
    });
});