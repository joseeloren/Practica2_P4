window.onload = function() {
    function actualiza_platos() {
        var buscar = $(this).val();
        $('#productos').children().children().each(function(index) {
            if(index == 0) return;
            var plato = $(this).children(':first').text();
            (plato.toLowerCase().indexOf(buscar) > -1) ? $(this).show() : $(this).hide();
        });
    }
    $('#buscador').on('keyup',actualiza_platos);
}
