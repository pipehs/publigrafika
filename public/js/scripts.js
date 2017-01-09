//función para eliminar datos (sustituye antigua funcion eliminar)
function eliminar2(id,name,kind,type)
{
	swal({   title: "Cuidado!",
		   text: "Está seguro de eliminar "+type+" "+name+"?",
		   type: "warning",   
		   showCancelButton: true,   
		   confirmButtonColor: "#31B404",   
		   confirmButtonText: "Eliminar",
		   cancelButtonText: "Cancelar",   
		   closeOnConfirm: false }, 
		   function(){
		   		$.get(kind+'.destroy.'+id, function (result) {
		   			if (result == 0)
		   			{
		   				swal({   title: "",
			   			   text: ""+type+" "+name+" fue eliminado(a) satisfactoriamente",
			   			   type: "success",   
			   			   showCancelButton: false,   
			   			   confirmButtonColor: "#31B404",   
			   			   confirmButtonText: "Aceptar",   
			   			   closeOnConfirm: false }, 
			   			   function(){   
			   			   	location.reload();
			   			});
		   			}
		   			else
		   			{
		   				swal({   title: "",
			   			   text: ""+type+" "+name+" no puede ser eliminado(a). Posiblemente contenga información asociada.",
			   			   type: "error",   
			   			   showCancelButton: false,   
			   			   confirmButtonColor: "#31B404",   
			   			   confirmButtonText: "Aceptar",   
			   			   closeOnConfirm: false }, 
			   			   function(){   
			   			   	location.reload();
			   			});
		   			}

		   		});	 
		   });
}

//función para verificar que existan cantidades
function verCantidades(id)
{
	$.get('corrugados.verificar_cant', function (result) {
		   			if (result == 0)
		   			{
		   				window.location.href = 'corrugados.precios.'+id
		   			}
		   			else
		   			{
		   				swal({   title: "",
			   			   text: "Primero debe agregar cantidades",
			   			   type: "error",   
			   			   showCancelButton: false,   
			   			   confirmButtonColor: "#31B404",   
			   			   confirmButtonText: "Aceptar",   
			   			   closeOnConfirm: false }, 
			   			   function(){   
			   			   	window.location.href = 'cantidades.create'
			   			});
		   			}

	});	 
}

function validarFechaMayorActual(date)
{
	//por error de js (que está restando un día a la fecha ingresada); modificaremos ésta para parsear como INT (y agregar hora)
	var date_temp = date.split('-');
    var today = new Date();
    var date2 = new Date(date_temp[0]+'-'+date_temp[1]+'-'+parseInt(date_temp[2]));

    //Actualización 02-11-2016: Agregamos validador de fecha menor a 31-12-9999
    var date3 = new Date('9999-12-'+parseInt(31));

    if (date2 > date3)
    {
    	swal('Error!','Está ingresando una fecha incorrecta. La fecha mayor a ingresar es 31-12-9999','error');
        $("#ver_date").prop('class','form-group has-error has-feedback');
        $("#submit").prop('disabled',true);
    }

    else if (date2 < today)
    {   
        swal('Cuidado!','Está ingresando una fecha menor a la fecha actual','warning');
        $("#ver_date").prop('class','form-group has-error has-feedback');
        $("#submit").prop('disabled',true);
    }
    else
    {
        $("#ver_date").prop('class','form-group');
        $("#submit").prop('disabled',false);
    }   
}
