/*
 * jQuery File Upload Plugin JS Example 6.5
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */

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
		       confirm('&iquest;Desea eliminar este archivo?<br/>Una vez eliminada ya no estara m&aacute;s en la revista esta imagen y no puede revertirse.','', function(){ delete_item(data,that); });
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
		$('.inputComentario, .inputEnlace').unbind();
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
		$('.inputEnlace').focus(function(){
			if($(this).val()=='Enlace'){
				$(this).val('');
			}
			$(this).removeClass('void');
		});
		$('.inputEnlace').blur(function(){
			if($(this).val()=='' || $(this).val()=='Enlace'){
				$(this).addClass('void');
				$(this).val('Enlace');
			}
		});
		$('.inputComentario, .inputEnlace').change(function(){
			$(this).parent().parent().find('.saveInfo').next().remove();
			$(this).parent().parent().find('.saveInfo').show();
		});
		
		$('.saveInfo').unbind();
		
		$('.saveInfo').click(function(){
			var id = $(this).attr('id').replace('save_','');
			var comentario = $('#com_'+id).val();
			var enlace = $('#enl_'+id).val();
			$.ajax({
				type: 'POST',
				url: '/admin/noticias/infoGaleria',
				data: {csrf_toyota_site: tyt_sec_val, noticia_id: noticia_id, id: id, comentario: comentario, enlace: enlace},
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
		url: '/admin/revista/saveOrden',
		data: {csrf_toyota_site: tyt_sec_val, noticia_id: noticia_id, orden: orden},
		dataType: 'json',
		success: function(data){
			
	  	}
	});
}
