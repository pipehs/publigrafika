cont = 2;
function masCantidades()
{
	var nuevo = '<div class="form-group">'
	nuevo += '<label class="col-sm-4 control-label" for="newcantidad_'+cont+'">Cantidad en Kg '+cont+'</label>'
	nuevo += '<div class="col-sm-2">'
	nuevo += '<input type="number" class="form-control" name="newcantidad_'+cont+'">'
	nuevo += '</div></div>'

	$('#mascantidades').append(nuevo)

	cont++
}