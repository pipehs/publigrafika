
$(function () {
    'use strict';
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
    	acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
    	destroy: function (e, data) {
	   		var that = $(this).data('fileupload');
		    var delete_all = false;
		    
		    if ( typeof e.originalEvent.originalEvent != "undefined" ) {
		    	//click en boton individual
		    	/*
		    	if (!(confirm("Desea eliminar este archivo?") == true )) {
		            return false;
		        }*/
		       confirm('&iquest;Desea eliminar este archivo?','', function(){ delete_item(data,that); });
		    }
		    else{
		    	delete_item(data,that);
		    	/*
			    if (data.url) {
	                $.ajax(data)
	                    .success(function () {
	                        that._adjustMaxNumberOfFiles(1);
	                        $(this).fadeOut(function () {
	                            $(this).remove();
	                        });
	                    });
	            } else {
	                data.context.fadeOut(function () {
	                    $(this).remove();
	                });
	            }  */
          	}
		}
	}).bind('fileuploadcompleted', function (e, data) {
		
		$.each(data.result, function (index, file) {
			if(file.comentario==''){
				$('#com_'+file.imagen_id).addClass('void');
				$('#com_'+file.imagen_id).val('Comentario');	
			}
			if(file.enlace==''){
				$('#enl_'+file.imagen_id).addClass('void');
				$('#enl_'+file.imagen_id).val('Enlace');	
			}
		});
		$('.inputComentario').unbind();
		$('.inputComentario').focus(function(){
			if($(this).val()=='Comentario'){
				$(this).val('');
			}
			$(this).removeClass('void');
		});
		$('.inputComentario').blur(function(){
			if($(this).val()=='' || $(this).val()=='Comentario'){
				$(this).addClass('void');
				$(this).val('Comentario');
			}
		});
		
		$('.inputComentario').change(function(){
			$(this).parent().parent().find('.saveInfo').next().remove();
			$(this).parent().parent().find('.saveInfo').show();
		});
		
		$('.saveInfo').unbind();
		
		$('.saveInfo').click(function(){
			var id = $(this).attr('id').replace('save_','');
			var comentario = $('#com_'+id).val();
			$.ajax({
				type: 'POST',
				url: '/admin/productos/infoGaleriaProducto',
				data: {cgs_csftoken: cgs_csftoken, producto_id: producto_id, id: id, comentario: comentario},
				dataType: 'json',
				success: function(data){
					if(data.success){
						$(this).hide();
						$(this).after('<span class="temp">Guardado correctamente</span>');
						$(this).next().fadeOut(3000, function(){
							$(this).remove();
						});
					}
					else{
						$(this).hide();
						$(this).after('<span class="temp">Error al guardar</span>');
					}
			  	}
			});
			
			
			$(this).hide();
			$(this).after('<span class="temp">Guardado correctamente</span>');
			$(this).next().fadeOut(3000, function(){
				$(this).remove();
			});
		});
    	guardar_orden();
	});
    // Load existing files:
    $('#fileupload').each(function () {
    	var that = this;
        $.getJSON(this.action, function (result) {
            if (result && result.length) {
            	$(that).fileupload('option', 'done')
                    .call(that, null, {result: result});
            }
        });
    });
    
	$( "#sortable" ).sortable({ 
		containment: '#sortable-container',
		activate: function(event, ui) {
			$('input').blur();
		},
		update: function(event, ui) {
			guardar_orden();
		} 
	});
	//$( "#sortable" ).disableSelection();
});

function delete_item(data,that){
	if (data.url) {
        $.ajax(data)
            .success(function () {
                that._adjustMaxNumberOfFiles(1);
                $(this).fadeOut(function () {
                    $(this).remove();
                });
            });
    } else {
        data.context.fadeOut(function () {
            $(this).remove();
        });
    } 
}

function guardar_orden(){
	var orden = '{';
	var id=0;
	var coma='';
	$('#sortable tr').each(function(){
		if(typeof $(this).attr('id') != 'undefined'){
			id = $(this).attr('id').replace('img_','');
			orden += coma+'"'+id+'":'+$(this).index();
			coma=',';
		}
	});
	orden += '}';
	$.ajax({
		type: 'POST',
		url: '/admin/productos/saveOrden',
		data: {cgs_csftoken: cgs_csftoken, producto_id: producto_id, orden: orden,galeria_producto:'true'},
		dataType: 'json',
		success: function(data){
			
	  	}
	});
}
