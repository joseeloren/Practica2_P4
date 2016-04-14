$(document).ready(function(){
    $('#borrar_servir').on('click','.listoParaServir',servirProducto);
    $('#borrar_servir').on('click',".eliminarArticulo",eliminarProducto);
    $('select').selectmenu();('change keydown', incluirProducto);
    $( 'select' ).on( "selectmenuselect", incluirProducto);
});



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
             alert('Error:'+res.message);
          }
       },
       error: function(res){
          alert('Error:'+res);
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
             alert('Error:'+res.message);
          }
       },
       error: function(res){
          alert('Error:'+res);
       }
    });
}

function incluirProducto(){
    var nombre_articulo = $(this).children('option:selected').text();
    var id_articulo = $(this).children('option:selected').val();
    var id_comanda = $(this).attr('id_comanda');
    var id_camarero = $(this).attr('id_camarero');
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
              }

          }else{
             alert('Error:'+res.message);
          }
       },
       error: function(res){
          alert('Error:'+res);
       }
    });
}
