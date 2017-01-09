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
		always: function(e, data){
			if(soa==0){
				soa = 1;
    			setTimeout('guardar_orden()',3000);
    		}
    		return true
    	},
    	destroy: function (e, data) {
	   		var that = $(this).data('fileupload');
		    var delete_all = false;
		    
		    if ( typeof e.originalEvent.originalEvent != "undefined" ) {
		       confirm('&iquest;Desea eliminar este archivo?','', function(){ delete_item(data,that); });
		    }
		    else{
		    	delete_item(data,that);
		    }
		    guardar_orden();
		}
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
		update: function(event, ui) {
			guardar_orden();
		} 
	});
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

var soa = 0;

function guardar_orden(){
	soa=0;
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
		url: '/admin/vehiculos/saveOrden',
		data: {csrf_toyota_site: tyt_sec_val, vehiculo_id: vehiculo_id, orden: orden},
		dataType: 'json',
		success: function(data){
		}
	});
}
