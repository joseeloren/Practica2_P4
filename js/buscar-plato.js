window.onload = function() {
    var buscar = document.getElementById("buscador");
    function actualiza_platos() {
        var platos = document.getElementById("productos").childNodes[1].childNodes;
        for(var i=2; i<platos.length;i=i+2){
            var plato = platos[i].childNodes[1].firstChild.nodeValue;
            platos[i].style.display =(plato.toLowerCase().indexOf(buscar.value) > -1)  ? 'table-row' : 'none';
        }
        console.log("entro");
    }
    buscar.onkeydown = actualiza_platos;
}
