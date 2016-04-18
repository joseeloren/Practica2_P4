$(document).ready(function(){
    $('#borrar_servir').on('click','.listoParaServir',servirProducto);
    $('#borrar_servir').on('click',".eliminarArticulo",eliminarProducto);
    $('.boton_peticion').on('click', incluirProducto);
    $('.nueva_comanda').on('click', add_comanda);
    $('.botonesP').on('click', indicarElaboracion);
    $('.botonesF').on('click', indicarFinalizacion);
    $('#buscador').on('keyup',actualiza_platos);
    if($('.n_comanda').length)
        $('.ocupada').hide();
    if($('#user').val() === "") {
        $('#identifi').hide();
    }
    $('#user').on('keyup', comprobar_campos);
    $('#pass').on('keyup', comprobar_campos);
});

function comprobar_campos() {
    if($('#user').val() !== "" && $('#pass').val() !== "")
        $('#identifi').show();
    else
        $('#identifi').hide();
}

function servirProducto(){
    var id_lineascomanda = $(this).attr('id_lineascomanda');
    var id_camarero = $(this).attr('id_camarero');
    var id_comanda = $(this).attr('id_comanda');
    $.ajax({
       url: "servir_producto_json.php",
       type: "POST",
       data: JSON.stringify({"id_linea":id_lineascomanda, "id_camarero": id_camarero}),
       dataType: "json",
       success: function(res){
          if(res.modified){
             $('#listoParaServir'+id_lineascomanda).remove();
             $('#precioTotal').parent().before('<tr><td>'+res.articulo+'</td><td>'+res.pvp+'</td></tr>');
             var precio = $('#precioTotal').text();
             precio = (parseFloat(precio)+parseFloat(res.pvp)).toFixed(2);

             $('#precioTotal').text(precio);
          }else{
             alert('Error: '+res.message);
          }
       },
       error: function(res){
          alert('Error: '+res);
       }
    });
}

function eliminarProducto(){
    var id_lineascomanda = $(this).attr('id_lineascomanda');
    $.ajax({
       url: "eliminar_producto_json.php",
       type: "POST",
       data: JSON.stringify({"id_linea":id_lineascomanda}),
       dataType: "json",
       success: function(res){
          if(res.deleted){
             $('#listoParaServir'+id_lineascomanda).remove();
          }else{
             alert('Error: '+res.message);
          }
       },
       error: function(res){
          alert('Error: '+res);
       }
    });
}

function incluirProducto(){
    var nombre_articulo = $('select').children('option:selected').text();
    var id_articulo = $('select').children('option:selected').val();
    var id_comanda = $('select').attr('id_comanda');
    var id_camarero = $('select').attr('id_camarero');
    $.ajax({
       url: "incluir_producto_json.php",
       type: "POST",
       data: JSON.stringify({"id_comanda":id_comanda, "id_articulo":id_articulo,"id_camarero":id_camarero}),
       dataType: "json",
       success: function(res){
          if(res.inserted){
              if(res.type == 0){
                  $('#borrar_servir').append('<tr id ="listoParaServir'+res.id_lineascomanda+'"> <td>'+nombre_articulo+'</td><td><button class="listoParaServir" id_lineascomanda="'+res.id_lineascomanda+'" id_camarero="'+id_camarero+'">Servir</button></td><td><button class="eliminarArticulo" id_lineascomanda="'+res.id_lineascomanda+'" >Eliminar</button></td></tr>');

              } else if(res.type == 1) {
                  $('#elaboracion').append('<tr><td>'+nombre_articulo+'</td><td>Pendiente</td></tr>');
              } else {
                 alert('Error: '+res.message);
              }

          }else{
             alert('Error: '+res.message);
          }
       },
       error: function(res){
          alert('Error: '+res);
       }
    });
}

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
                alert('Error: ' + res.message);
            }

           },
           error: function(res){
               alert('Error: ' + res);
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
                alert('Error: ' + res.message);
            }
           },
           error: function(res){
                alert('Error: ' + res);
           }
        });
}

function add_comanda() {
    var id_mesa = $(this).attr("id_mesa");
    var id_camarero = $(this).attr("id_camarero");
    $.ajax({
        url: "../php/add_comanda_json.php",
        type: "POST",
        data: JSON.stringify({"id_mesa":id_mesa, "id_camarero":id_camarero,}),
        dataType: "json",
        success: function(res){
          if(res.id_comanda != -1){
              $(".n_comanda").hide();
              $(".ocupada").show();
              $(".ocupada").attr("id_comanda", res.id_comanda);
          } else {
              alert('Error: ' + res.message);
          }

        },
        error: function(res){
            alert('Error: ' + res);
        }
     });
}

function actualiza_platos() {
    var buscar = $(this).val();
    $('#productos').children().children().each(function(index) {
        if(index == 0) return;
        var plato = $(this).children(':first').text();
        (plato.toLowerCase().indexOf(buscar) > -1) ? $(this).show() : $(this).hide();
    });
}




