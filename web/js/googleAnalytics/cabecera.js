$("#eventRadio").on("click", function () {
    ga('send', 'event', {
        eventCategory: 'Click Radio',
        eventAction: 'click',
        eventLabel: '#eventRadio'
    });
});

$("#eventRegistrarse").on("click", function () {
    ga('send', 'event', {
        eventCategory: 'Click Registro',
        eventAction: 'click',
        eventLabel: '#eventRegistrarse'
    });
});