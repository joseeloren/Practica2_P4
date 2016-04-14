function indicarElaboracion() {
    var id_usuario = $(this).attr("id_usuario");
    var id_lineascomanda = $(this).attr("id_lineascomanda");
    var articulo = $(this).attr("articulo");
    var mesa =  $(this).attr("mesa");
     $.ajax({
        url: "../php/indicar_elaboracion_json.php",
        type: "POST",
        data: JSON.stringify({"id":id_lineascomanda,"idUser":id_usuario}),
        dataType: "json",
        success: function(res){
          if(res.modified){
           $('#pendiente'+id_lineascomanda).remove();
            $('#tablaHaciendo').append($('<tr id="haciendo'+id_lineascomanda+'"><td>'+ articulo+'</td><td>'+mesa+'</td><td><button id="boton'+id_lineascomanda+'" class ="botonesF"  id_lineascomanda="'+id_lineascomanda+'"> Finalizar</button> </td>'));
            $('#boton'+id_lineascomanda).on('click', indicarFinalizacion);
            }else{

            }

           },
           error: function(res){

           }
        });
}

function indicarFinalizacion() {
     var id_lineascomanda = $(this).attr("id_lineascomanda");
     $.ajax({
        url: "../php/indicar_finalizacion_json.php",
        type: "POST",
        data: JSON.stringify({"id":id_lineascomanda}),
        dataType: "json",
        success: function(res){
          if(res.modified){
           $('#haciendo'+id_lineascomanda).remove();
            }else{

            }

           },
           error: function(res){

           }
        });
}

$(document).ready(function(){
    console.log("creo eventos");
    $('.botonesP').on('click', indicarElaboracion);
    $('.botonesF').on('click', indicarFinalizacion);
});

