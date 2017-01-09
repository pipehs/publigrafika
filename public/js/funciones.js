function enviaSelect(vista,valor)
{
    if(valor==0)
    {
        return false;
    }
    switch(vista)
    {
        case 'cotizaciones':
            window.location=webroot+"cotizaciones/search1/"+valor;
        break;
        case 'usuarios':
            switch(valor)
            {
                case '1':
                    window.location=webroot+"usuarios/";
                break;
                 case '2':
                    window.location=webroot+"usuarios/vendedores";
                break;
            }
        break;
        case 'clientes':
            switch(valor)
            {
                case '1':
                    window.location=webroot+"clientes/";
                break;
                 case '2':
                    window.location=webroot+"clientes/activos";
                break;
                case '3':
                    window.location=webroot+"clientes/no_activos";
                break;
            }
        break;
        case 'clientes_cotizacion':
            window.location=webroot+"cotizaciones/clientes/"+valor;
        break;
        case 'materiales':
            switch(valor)
            {
                case '1':
                    window.location=webroot+"materiales/tipo/1";
                break;
                 case '2':
                     window.location=webroot+"materiales/tipo/2";
                break;
                case '3':
                     window.location=webroot+"materiales/tipo/3";
                break;
                case '4':
                     window.location=webroot+"materiales/tipo/4";
                break;
            }
        break;
        case 'productos':
            window.location=webroot+"productos/por_cliente/"+valor;
        break;
        case 'productos_tipo':
            window.location=webroot+"productos/por_tipo/"+valor;
        break;
    }
}
function redondeo2decimales(numero)
{
var flotante = parseFloat(numero);
var resultado = Math.round(flotante*100)/100;
return resultado;
}
function sumaGrameje()
{
     var valor=document.form.onda.value;
     var uno=document.form.gramaje.value;
     
     uno=parseInt(uno) ;
     var dos=document.form.gramaje2.value;
     dos=parseInt(dos) ;
     var precio1=document.form.precio_onda.value;
     var precio2=document.form.precio_liner.value;
     precio1=parseInt(precio1);
     precio2=parseInt(precio2);
     suma=uno+dos;
     //alert("valor="+valor+"\n"+"uno="+uno+"\n"+"dos="+dos+"\n"+"suma="+suma);
      //calculo el gramaje
      if(valor=="Microcorrugado")
      {
        g=uno*1.3+dos;
      }else
        {
        g=uno*1.37+dos;
        }
                              
     document.form.gramaje_real.value=g;
     //calculo el precio
     gramaje1=uno*1.3;
     
     total=gramaje1+dos;
     
     total1=gramaje1/total*precio1;
     total2=dos/total*precio2;
     //alert("total1="+total1+"\ntotal2="+total2);
     total3=total1+total2+140;
     document.form.precio.value=redondeo2decimales(total3);
     
     
}
 function carga_ajax5(ruta,valor1,div) 
        {
           
           //alert(valor1 );
           $.post(ruta,{valor1:valor1},function(resp)
           {
                $("#"+div+"").html(resp);
           });
           return false;
           
        }   
function enviaSelect2(valor)
{
    if(valor>=1)
    {
        window.location=webroot+"materiales/tipo/"+valor;
    }
}
function enviaClientesProductos(id)
{
    if(id>=1)
    {
        window.location=webroot+"productos_asociados/clientes/"+id;
    }
}
function carga_ajax(ruta,valor1,valor2,div) 
        {
          // alert(ruta );
           $.post(ruta,{valor1:valor1,valor2:valor2},function(resp)
           {
                $("#"+div+"").html(resp);
           });
        }
function carga_ajax15(ruta,valor1,valor2,valor3,div) 
        {
         //  alert(ruta );
           $.post(ruta,{valor1:valor1,valor2:valor2,valor3:valor3},function(resp)
           {
                $("#"+div+"").html(resp);
           });
        }
		
function carga_ajax16(ruta,valor1,valor2,valor3,valor4,div) 
        {
          // alert(ruta );
           $.post(ruta,{valor1:valor1,valor2:valor2,valor3:valor3,valor4:valor4},function(resp)
           {
                $("#"+div+"").html(resp);
           });
        }
		
function carga_ajax3(ruta,valor1,valor2,div) 
        {
           if(valor1==3000)
           {
             $("#"+div+"").html("");
             return false;
           }
          // alert(ruta );
           $.post(ruta,{valor1:valor1,valor2:valor2},function(resp)
           {
                $("#"+div+"").html(resp);
           });
        }   
 function carga_ajax4(ruta,valor1,div) 
        {
           
           //alert(valor1 );
           $.post(ruta,{valor1:valor1},function(resp)
           {
                $("#"+div+"").html(resp);
           });
        } 
    
function carga_ajax2(ruta,valor1,div) 
        {
           //alert(valor1);
           if(valor1==0)
           {
                $.post(ruta,{valor1:valor1,valor2:3000},function(resp)
                   {
                        $("#"+div+"").html(resp);
                   });
           }else
           {
               //alert(document.form.cliente.value);
               $.post(ruta,{valor1:valor1,valor2:document.form.cliente.value},function(resp)
               {
                    $("#"+div+"").html(resp);
               });
              
           }
        }        
function formatear(valor,id)
{
    //alert(dar_formato(valor));
    document.getElementById(id).value=dar_formato(valor);
}        
function eliminar(url)
{
    if(confirm("Realmente desea eliminar este registro?"))
    {
        window.location=url;
    }
}
function alpha(e) 
         {
         key = e.keyCode || e.which;
           tecla = String.fromCharCode(key).toLowerCase();
           //alert(key);
           letras = " ÃƒÂ¡ÃƒÂ©ÃƒÂ­ÃƒÂ³ÃƒÂºabcdefghijklmnÃƒÂ±opqrstuvwxyz";
           //especiales = [8,37,39,46];
            especiales = [8,39,46,241,225,233,237,243,250];
           tecla_especial = false
           for(var i in especiales){
                if(key == especiales[i]){
                    tecla_especial = true;
                    break;
                }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
}

function soloNumeros(evt)
{
	key = (document.all) ? evt.keyCode :evt.which;
	//alert(key);
    if(key==17)return false;
	/* digitos,del, sup,tab,arrows*/
	return ((key >= 48 && key <= 57) || key == 8 || key == 127 || key == 9 || key==0);
}


function soloNumerosConPuntos(evt)
{
	key = (document.all) ? evt.keyCode :evt.which;
	//alert(key);
    if(key==17)return false;
	/* digitos,del, sup,tab,arrows*/
	return ((key >= 48 && key <= 57) || key == 8 || key == 127 || key == 9 || key==0 || key==46);
}

function soloNumerosConPuntosYComas(evt)
{
	key = (document.all) ? evt.keyCode :evt.which;
	//alert(key);
    if(key==17)return false;
	/* digitos,del, sup,tab,arrows*/
	document.getElementById(valorAcabado).value = document.getElementById(valorAcabado).value.replace('.',',') 
	return ((key >= 48 && key <= 57) || key == 8 || key == 127 || key == 9 || key==0 || key==188);
}

function espacio_a_guiones(cadena,campo)

{
    
    cadena= cadena.replace(/\s/g,"-");
alert(cadena);
    document.getElementById(campo).value=cadena;    

}
function cambiaFolia()
{
    var form=document.form;
    if(form.folia.value=="NO")
    {
        document.getElementById('folia_se_a').style.display='none';
        document.getElementById('folia_se_b').style.display='block';
        form.folia_se.value="No Lleva";
        return false;
    }else
    {
        document.getElementById('folia_se_a').style.display='block';
        document.getElementById('folia_se_b').style.display='none';
        form.folia_se.value="Nuevo";
        return false;
    }
}
function cambiaFolia2()
{
    var form=document.form;
    
    if(form.folia_2.value=="NO")
    {
        document.getElementById('folia_se_2_a').style.display='none';
        document.getElementById('folia_se_2_b').style.display='block';
        form.folia_se_2.value="No Lleva";
        return false;
    }else
    {
        document.getElementById('folia_se_2_a').style.display='block';
        document.getElementById('folia_se_2_b').style.display='none';
        form.folia_se_2.value="Nuevo";
        return false;
    }
}
function cambiaFolia3()
{
    var form=document.form;
    if(form.folia_3.value=="NO")
    {
        document.getElementById('folia_se_3_a').style.display='none';
        document.getElementById('folia_se_3_b').style.display='block';
        form.folia_se_3.value="No Lleva";
        return false;
    }else
    {
        document.getElementById('folia_se_3_a').style.display='block';
        document.getElementById('folia_se_3_b').style.display='none';
        form.folia_se_3.value="Nuevo";
        return false;
    }
}
function cambiaCuno()
{
    var form=document.form;
    if(form.cuno.value=="NO")
    {
        document.getElementById('cuno_se_a').style.display='none';
        document.getElementById('cuno_se_b').style.display='block';
        form.folia_se.value="No Lleva";
        return false;
    }else
    {
        document.getElementById('cuno_se_a').style.display='block';
        document.getElementById('cuno_se_b').style.display='none';
        form.cuno_se.value="Nuevo";
        return false;
    }
}
function cambiaCuno2()
{
    var form=document.form;
   if(form.cuno_2.value=="NO")
    {
        document.getElementById('cuno_se_2_a').style.display='none';
        document.getElementById('cuno_se_2_b').style.display='block';
        form.folia_se.value="No Lleva";
        return false;
    }else
    {
        document.getElementById('cuno_se_2_a').style.display='block';
        document.getElementById('cuno_se_2_b').style.display='none';
        form.cuno_se_2.value="Nuevo";
        return false;
    }
}
function validaParcial()
{
    var can_despacho_1=parseInt(document.form.can_despacho_1.value);
    var can_despacho_2=parseInt(document.form.can_despacho_2.value);
    var can_despacho_3=parseInt(document.form.can_despacho_3.value);
    var suma=can_despacho_1+can_despacho_2+can_despacho_3;
    //alert(suma);
    if(suma>100)
    {
        alert("la suma de las cantidades no debe sumar mas de 100");
        document.form.can_despacho_1.value="";
        document.form.can_despacho_2.value="";
        document.form.can_despacho_3.value="";
        document.form.can_despacho_1.focus();
        return false;
    }
}
function tipoPegado()
{
    var tipo_de_pegado1=document.form.tipo_de_pegado1.value;
    if(tipo_de_pegado1=="No Lleva")
    {
        document.getElementById("pegado").style.display="none";
    }else
    {
        document.getElementById("pegado").style.display="block";
    }
}
function tamano1NoMasDe100()
{
    var tamano_1=parseInt(document.form.tamano_1.value);
    if(tamano_1>100)
    {
        document.form.tamano_1.value="";
        document.form.tamano_1.focus();
        return false;
    }
}
function tamano2NoMasDe100()
{
    var tamano_2=parseInt(document.form.tamano_2.value);
    if(tamano_2>141)
    {
        document.form.tamano_2.value="";
        document.form.tamano_2.focus();
        return false;
    }
}
function cuchillo()
{
    var tamano_1=parseInt(document.form.tamano_1.value);
    var tamano_2=parseInt(document.form.tamano_2.value);
    var tamano_cuchillo_1=parseInt(document.form.tamano_cuchillo_1.value);
    var tamano_cuchillo_2=parseInt(document.form.tamano_cuchillo_2.value);
    //|| tamano_cuchillo_1 >tamano_2 || tamano_cuchillo_2 >tamano_1 || tamano_cuchillo_2 >tamano_2
   // alert(tamano_cuchillo_1);return false;
    if(tamano_cuchillo_1 > tamano_1 )
    {
        alert("Distancia cuchillo a cuchillo debe ser menor que tamaño a imprimir");
        document.form.tamano_cuchillo_1.value="";
        document.form.tamano_cuchillo_1.focus();
        return false;
    }
    if(tamano_cuchillo_1 == tamano_1 )
    {
        alert("Distancia cuchillo a cuchillo debe ser menor que tamaño a imprimir");
        //document.form.tamano_cuchillo_1.value=tamano_1-1;
        document.form.tamano_cuchillo_1.value=0;
        //document.form.tamano_cuchillo_1.focus();
        return false;
    }
    if(tamano_cuchillo_2 > tamano_2 )
    {
        alert("Distancia cuchillo a cuchillo debe ser menor que tamaño a imprimir");
        document.form.tamano_cuchillo_2.value="";
        document.form.tamano_cuchillo_2.focus();
        return false;
    }
    if(tamano_cuchillo_2 == tamano_2 )
    {
        alert("Distancia cuchillo a cuchillo debe ser menor que tamaño a imprimir");
        //document.form.tamano_cuchillo_2.value=tamano_2-1;
        document.form.tamano_cuchillo_2.value=0;
        //document.form.tamano_cuchillo_2.focus();
        return false;
    }
}
function enviarCliente()
{
    var cliente=document.form.cliente.value;
    window.location=webroot+"cotizaciones/buscar2_respuesta/"+cliente;
}
function liberar(valor)
{
    document.form.indicador.value=valor;
    document.form.submit();
}
function llamarDetalleCondicion(id)
{
    if(id==0)
    {
        document.getElementById("productos_asociados").innerHTML='';
        document.form.producto.value='';
        document.form.producto_id=0;
        return false;
    }
	if(id==1)
    {
        document.getElementById("div_condicion").style.display='block';
        carga_ajax(webroot+'productos/ajax',document.form.cliente.value,'ll1','productos_asociados');
    }
    /*if(id==2)
    {
        document.getElementById("div_condicion").style.display='block';
        carga_ajax(webroot+'productos/ajax',document.form.cliente.value,document.form.condicion_del_producto.value,'productos_asociados');
    }*/
	/*else
    {
        document.getElementById("div_condicion").style.display='none';
        document.getElementById("productos_asociados").innerHTML='';
        document.form.producto.value='';
        document.form.producto_id=0;
    }*/
	if(id==3)
    {
        document.getElementById("div_condicion").style.display='block';
        carga_ajax(webroot+'productos/ajaxProductosGenericos',document.form.cliente.value,'ss','productos_asociados');
    }
}
function asignaNombreProductoSolicitudDeCotizacion(valor,id)
{
    document.form.producto.value=valor;
    document.form.producto_id.value=id;
}
function cambiaBuscador(id)
{
    if(id==1)
    {
        document.getElementById("numero").style.display='none';
        document.getElementById("termino").style.display='block';
        document.getElementById("op").style.display='none';
		document.getElementById("NMolde").style.display='none';
		document.getElementById("NomMolde").style.display='none';
		document.getElementById("tipomolde").style.display='none';
		document.getElementById("NomProducto").style.display='none';
		document.getElementById("NProducto").style.display='none';
        return false;   
    }
    if(id==2)
    {
        document.getElementById("numero").style.display='block';
        document.getElementById("termino").style.display='none';
        document.getElementById("op").style.display='none';
		document.getElementById("NMolde").style.display='none';
		document.getElementById("NomMolde").style.display='none';
		document.getElementById("tipomolde").style.display='none';
		document.getElementById("NomProducto").style.display='none';
		document.getElementById("NProducto").style.display='none';
        return false;   
    }
    if(id==3)
    {
        document.getElementById("numero").style.display='none';
        document.getElementById("termino").style.display='none';
        document.getElementById("op").style.display='block';
		document.getElementById("NMolde").style.display='none';
		document.getElementById("NomMolde").style.display='none';
		document.getElementById("tipomolde").style.display='none';
		document.getElementById("NomProducto").style.display='none';
		document.getElementById("NProducto").style.display='none';
        return false;   
    }
	if(id==4)
    {
        document.getElementById("numero").style.display='none';
        document.getElementById("termino").style.display='none';
        document.getElementById("op").style.display='none';
		document.getElementById("NMolde").style.display='block';
		document.getElementById("NomMolde").style.display='none';
		document.getElementById("tipomolde").style.display='block';
		document.getElementById("NomProducto").style.display='none';
		document.getElementById("NProducto").style.display='none';
        return false;   
    }
	if(id==5)
    {
        document.getElementById("numero").style.display='none';
        document.getElementById("termino").style.display='none';
        document.getElementById("op").style.display='none';
		document.getElementById("NMolde").style.display='none';
		document.getElementById("NomMolde").style.display='block';
		document.getElementById("tipomolde").style.display='block';
		document.getElementById("NomProducto").style.display='none';
		document.getElementById("NProducto").style.display='none';
        return false;   
    }
		if(id==6)
    {
        document.getElementById("numero").style.display='none';
        document.getElementById("termino").style.display='none';
        document.getElementById("op").style.display='none';
		document.getElementById("NMolde").style.display='none';
		document.getElementById("NomMolde").style.display='none';
		document.getElementById("tipomolde").style.display='none';
		document.getElementById("NomProducto").style.display='block';
		document.getElementById("NProducto").style.display='none';
        return false;   
    }
		if(id==7)
    {
        document.getElementById("numero").style.display='none';
        document.getElementById("termino").style.display='none';
        document.getElementById("op").style.display='none';
		document.getElementById("NMolde").style.display='none';
		document.getElementById("NomMolde").style.display='none';
		document.getElementById("tipomolde").style.display='none';
		document.getElementById("NomProducto").style.display='none';
		document.getElementById("NProducto").style.display='block';
        return false;   
    }
}
function aceptaExcedentes()
{
    var form=document.form;
    if(form.acepta_excedentes.value=="SI")
    {
        form.acepta_excedentes_extra.value="Acepta excedentes mas o menos 10%";
        document.getElementById('acepta_excedentes').innerHTML="Acepta excedentes mas o menos 10%";
        return false;
    }
    if(form.acepta_excedentes.value=="NO")
    {
        document.getElementById('acepta_excedentes').innerHTML="Acepta pagar extra por cantidad exacta";
        form.acepta_excedentes_extra.value="Acepta pagar extra por cantidad exacta";
        return false;
    }
}
function detalleDeMuestra()
{
    var form=document.form;
    //alert(form.solicita_muestra.value);
    if(form.solicita_muestra.value=="SI")
    {
        document.getElementById("div_muestra").style.display='block';
       
    }
}
function bloqueo()
{
    var form=document.form;
    //alert(form.solicita_muestra.value);
    if(form.estado.value=="2")
    {
        document.getElementById("div_bloqueo").style.display='block';
    }else
    {
        document.getElementById("div_bloqueo").style.display='none';
    }
}
function enviaCorreo(url)
{
    if(document.formcorreo.mensaje.value==0)
    {
        document.formcorreo.mensaje.value='';
        document.formcorreo.mensaje.focus();
        return false;
    }
        document.formcorreo.url.value=url;
        document.formcorreo.submit();
}
function enviarFotomecanica(valor)
{
    if(valor=="1")
    {
        if(confirm("Realmente desea liberar?"))
        {
            document.form.estado_fotomecanica.value=valor;
        document.form.submit();
        }
    }
    
    
}
function sbif()
{
    document.form.dolar.value=document.form.dolar_actual.value;
    document.form.uf.value=document.form.uf_actual.value;
    document.form.submit();
}
function LiberarSolitiaMuestra(url)
{
    if(confirm("Realmente desea liberar este registro?"))
    {
        window.location=url;
    }
}
function guardarFormulario(valor)
{
    var form=document.form;
    form.estado.value=valor;
    form.submit();
}
function guardarFormularioAdd(valor)
{
    var form=document.form;
    form.estado.value=valor;
    if(valor=='2')
    {
        document.getElementById('rechazo').style.display='block';
    }else
    {
        document.getElementById('rechazo').style.display='none';
    }
    if(valor=='2' && form.glosa.value=='')
    {
        alert("Debe indicar por qué rechaza");
        form.glosa.value="";
        form.glosa.focus();
        return false;
    }
	
	if(valor=='3')
    {
        form.estado.value=valor;
    }
    
    form.submit();
}
function fn_cb_totalOparcial(id,div)
{
    if(id=="Total")
    {
        document.getElementById(div).style.display='none';
    }else
    {
        document.getElementById(div).style.display='block';
    }
}
function creaMolde(id)
{
    switch(id)
    {
        case 'SI':
            document.getElementById("elije_molde").style.display='none';
            document.getElementById("crea_molde").style.display='block';
        break;
        case 'NO':
            document.getElementById("elije_molde").style.display='block';
            document.getElementById("crea_molde").style.display='none';
        break;
    }
}
function hacerTroquelIngenieria(id)//81486954 //27151987 13350 2014 // 
{
    if(id=="NO")
    {
        document.getElementById("metros_de_cuchillo").readOnly = true;
    }else
    {
        document.getElementById("metros_de_cuchillo").readOnly = false;
    }
    
}
function pegadoyAdhesivos2(id)//81486954 //27151987 13350 2014 // 
{
    //alert(id);
    
    if(id=="2")//Latex Consigomismo
    {
        document.getElementById("lleva_aletas").style.display = "block";
        document.getElementById("total_aplicaciones_adhesivo").style.display = "block";
    }else
    {
        document.getElementById("lleva_aletas").style.display = "none";
        document.getElementById("total_aplicaciones_adhesivo").style.display = "none";
    }
    
}
function pegadoyAdhesivos(id)//81486954 //27151987 13350 2014 // 
{
    //alert(id);
    if(id=="3")//PVA E-0002 Cola Blanca
    {
        document.getElementById("pegado_manual").style.display = "block";
    }else
    {
        document.getElementById("pegado_manual").style.display = "none";
    }
    if(id=="2")//Latex Consigomismo
    {
        document.getElementById("lleva_aletas").style.display = "block";
        document.getElementById("total_aplicaciones_adhesivo").style.display = "block";
    }else
    {
        document.getElementById("lleva_aletas").style.display = "none";
        document.getElementById("total_aplicaciones_adhesivo").style.display = "none";
    }
    
}
function alpha_con_numeros(e){
       key = e.keyCode || e.which;
       //alert(key);
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " Ã¡Ã©Ã­Ã³ÃºabcdefghijklmnÃ±opqrstuvwxyz1234567890";
       //especiales = [8,37,39,46];
        especiales = [8,39,45,46,241,225,233,237,243,250,9,13,64];
       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
function llevaBarnizFotomecanica2()
{
    var lleva_barniz=document.form.lleva_barniz.value;
    var acabado_impresion_1=document.form.acabado_impresion_1.value;
    if(acabado_impresion_1=='100')
    {
        document.getElementById('reserva_barniz').style.display='block';
        document.form.reserva_barniz.value='SI';
        document.form.lleva_barniz.value='SI';
        return false;
       
    }else
    {
        document.getElementById('reserva_barniz').style.display='none';
        document.form.lleva_barniz.value='NO';
        return false;
    }
}
function llevaBarnizFotomecanica()
{
    var lleva_barniz=document.form.lleva_barniz.value;
    if(lleva_barniz=='SI')
    {
        document.getElementById('reserva_barniz').style.display='block';
        document.form.reserva_barniz.value='SI';
        return false;
    }else
    {
        document.getElementById('reserva_barniz').style.display='none';
        document.form.reserva_barniz.value='NO';
        return false;
    }
}
function moldeparaingenieria()
{
    var estan_los_moldes=document.form.estan_los_moldes.value;
    var hacer_troquel=document.form.hacer_troquel.value;
    var lleva_troquelado=document.form.lleva_troquelado.value;
    if(lleva_troquelado=='NO')
    {
        document.form.estan_los_moldes.value='NO';
        document.form.hacer_troquel.value='NO';
        document.form.molde.value ='8371';
        document.getElementById('estan_los_moldes').style.display='none';
        document.getElementById('hacer_troquel').style.display='none';
        document.getElementById('crea_molde').style.display='none';
        return false;
    }else
    {
        document.getElementById('estan_los_moldes').style.display='block';
        document.getElementById('hacer_troquel').style.display='block';
        document.getElementById('crea_molde').style.display='block';
        return false;
    }
}
function nuevaParaTroquel()
{
    var lleva_troquelado=document.form.lleva_troquelado.value;
    var hacer_troquel=document.form.hacer_troquel.value;
    var estan_los_moldes=document.form.estan_los_moldes.value;
    if(lleva_troquelado=='SI' || hacer_troquel=='SI')
    {
        document.form.estan_los_moldes.value='NO';
    }else
    {
        document.form.estan_los_moldes.value='SI';
    }
}
function procesosInternos()
{
    var acabado_impresion_1=document.form.acabado_impresion_1.value;
    var acabado_impresion_2=document.form.acabado_impresion_2.value;
    var acabado_impresion_3=document.form.acabado_impresion_3.value;
    if(acabado_impresion_1==acabado_impresion_2)
    {
        alert("No se pueden repetir los acabados internos");
        document.form.acabado_impresion_1.value='16';
        document.form.acabado_impresion_2.value='16';
        document.form.acabado_impresion_3.value='16';
        return false;
    }
    if(acabado_impresion_1==acabado_impresion_3)
    {
        alert("No se pueden repetir los acabados internos");
        document.form.acabado_impresion_1.value='16';
        document.form.acabado_impresion_2.value='16';
        document.form.acabado_impresion_3.value='16';
        return false;
    }
    if(acabado_impresion_3==acabado_impresion_2)
    {
        alert("No se pueden repetir los acabados internos");
        document.form.acabado_impresion_1.value='16';
        document.form.acabado_impresion_2.value='16';
        document.form.acabado_impresion_3.value='16';
        return false;
    }
}
function procesosExternos()
{
    var acabado_impresion_4=document.form.acabado_impresion_4.value;
    var acabado_impresion_5=document.form.acabado_impresion_5.value;
    var acabado_impresion_6=document.form.acabado_impresion_6.value;
    if(acabado_impresion_4==acabado_impresion_5)
    {
        alert("No se pueden repetir los acabados externos");
        document.form.acabado_impresion_4.value='17';
        document.form.acabado_impresion_5.value='17';
        document.form.acabado_impresion_6.value='17';
        return false;
    }
    if(acabado_impresion_4==acabado_impresion_6)
    {
        alert("No se pueden repetir los acabados externos");
        document.form.acabado_impresion_4.value='17';
        document.form.acabado_impresion_5.value='17';
        document.form.acabado_impresion_6.value='17';
        return false;
    }
    if(acabado_impresion_6==acabado_impresion_5)
    {
        alert("No se pueden repetir los acabados externos");
        document.form.acabado_impresion_4.value='17';
        document.form.acabado_impresion_5.value='17';
        document.form.acabado_impresion_6.value='17';
        return false;
    }
}
function estanLosMoldes(id)
{
    if(id=='NO')
    {
        document.getElementById('molde_select').style.display='none';
        //document.getElementById('crea_molde').style.display='block';
    }else
    {
        document.getElementById('molde_select').style.display='block';
        //document.getElementById('crea_molde').style.display='none';
    }
}
function estanLosMoldes2(id)
{
    if(id=='NO')
    {
        //document.getElementById('molde_select').style.display='none';
        document.getElementById('molde_select').style.visibility='hidden';
        document.getElementById('crea_molde').style.display='block';
		document.getElementById('metroDeCuchillo').style.display='block';
        return false;
    }
    if(id=='SI')
    {
        //document.getElementById('molde_select').style.display='block';
		document.getElementById('molde_select').style.visibility='initial';
        document.getElementById('crea_molde').style.display='none';
		document.getElementById('metroDeCuchillo').style.display='none';
        return false; 
    }
    if(id=='NO LLEVA' || id=='CLIENTE LO APORTA')
    {
        //document.getElementById('molde_select').style.display='none';
        document.getElementById('molde_select').style.visibility='hidden';
        document.getElementById('crea_molde').style.display='none';
		document.getElementById('metroDeCuchillo').style.display='none';
        return false; 
    }
}
/***************órdenes de producción anexas************************/
function listaOrdenes(ruta,valor1,valor2,valor3,div)
{
    //var valor1=parseInt(valor1) ;
    if(valor1=='NO')
    {
        document.getElementById(div).innerHTML='';
        return false;
    }
    carga_ajax15(ruta,valor1,valor2,valor3,div);
}
function hayEnStock(id)
{
    if(id=='NO')
    {
        document.getElementById('stock_2').style.display='block';
        document.getElementById('stock_1').style.display='none';
        if(document.form.stock_opciones.value=='comprar')
        {
            document.getElementById('stock_3').style.display='block';
        }else
        {
            document.getElementById('stock_3').style.display='none';
        }
        return false;
    }else
    {
        document.getElementById('stock_1').style.display='block';
        document.getElementById('stock_2').style.display='none';
        document.getElementById('stock_3').style.display='none';
        return false;
    }
}
function hayEnStock2(id)
{
    if(id=='comprar')
    {
        document.getElementById('stock_3').style.display='block';
        return false;
    }else
    {
        document.getElementById('stock_3').style.display='none';
        return false;
    }
}
function guardarHC()
{
    if(confirm('Está seguro de que desea guardar todos los datos de la Hoja de Costos?'))
    {
        document.form.submit();
    }
}
function imprentaProgramacion(id)
{
    if(id=='Externo')
    {
        document.getElementById('proveedor').style.display='block';
        return false;
    }else
    {
        document.getElementById('proveedor').style.display='none';
        return false;
    }
}
function condicionParaMoldes(id)
{
    
    if(id=='1')
    {
        document.form.estan_los_moldes.value='SI';
        document.getElementById('molde_select').style.display='block';
        return false;
    }else
    {
        document.form.estan_los_moldes.value='NO';
        document.getElementById('molde_select').style.display='none';
        return false;
    }
	
}
	
	function ValidarNombreProducto()
		{	
		document.getElementById("div_condicion").style.display='block';
		carga_ajax(webroot+'productos/validarNombreProductoExistente',document.form.producto.value,'Nuevo','productos_asociados');		
		 /*if(confirm(''))
			{

			}*/
		}
	
	
	function ValidarCantidadesDeAcuerdoRangoMargenCotizados(id)
		{	
		//document.getElementById("div_condicion").style.display='block';
		//alert("I am an alert box! "+id);
		carga_ajax(webroot+'cotizaciones/validarCantidadesMargen',document.form.cantidad_de_cajas.value,id,'cantidades_margen');		
		
		}

		
		
	function ValidarPreciosDeAcuerdoRangoMargenCotizados(id)
		{	
		//carga_ajax(webroot+'cotizaciones/validarValoresMargen',document.form.cantidad_de_cajas.value,id,'Confirma_precio');		
		carga_ajax15(webroot+'cotizaciones/validarValoresMargen',document.form.cantidad_de_cajas.value,id,document.form.precio.value,'Confirma_precio');	
		}	
		
		
		
	function ValidarCantidadesDeAcuerdoRangoMargenCotizadosOP(id)
		{	
		//document.getElementById("div_condicion").style.display='block';
		//alert("I am an alert box! "+id);
		carga_ajax(webroot+'cotizaciones/validarCantidadesMargen',document.form.cantidad_pedida.value,id,'cantidades_margen');		
		
		}		
		
					
	function ValidarPreciosDeAcuerdoRangoMargenCotizadosOP(id)
		{	
		//carga_ajax(webroot+'cotizaciones/validarValoresMargen',document.form.cantidad_de_cajas.value,id,'Confirma_precio');		
		carga_ajax15(webroot+'cotizaciones/validarValoresMargen',document.form.cantidad_pedida.value,id,document.form.valor.value,'Confirma_precio');	
		}	
		
function condicionParaMoldesGenericos(id)
{
    
    if(id=='MOLDE GENERICO')
    {
        document.form.estan_los_moldes.value="SI";
		document.getElementById("estan_los_moldes_generico").style.display='block';
		document.getElementById("molde_select").style.display='block';
		document.getElementById("estan_los_moldes").style.display='none';
        return false;
    }
	
	if(id=='NO')
    {
        document.form.estan_los_moldes1.value="NO";
		document.getElementById("estan_los_moldes_generico").style.display='none';
		document.getElementById("molde_select").style.display='none'
		
        document.getElementById("estan_los_moldes").style.display='block';
        return false;
    }
	
}	





function llamarlink(id)
{      
		var idd = id;
		//id2 = id;
	//	document.getElementById("link3").innerHTML =id2;	
		//document.getElementById("link3").innerHTML =id;
		//document.getElementById("link2").style.display='block';	   
        return false;   	
		
}


function Repajax(id)
{
	if(id >= 1)
    {
        carga_ajax(webroot+'productos/ajaxlink',id,'ll1','productos_asociados2');
		
	}
}

function Repajax2(id)
{
	if(id >= 1)
    {
        carga_ajax(webroot+'productos/ajaxlink',id,'ll1','productos_asociados3');
		
	}
}

		
		function ClienteFaltaDatos()
		{
		  alert('El cliente no contiene Todos los datos o NO esta Activo: Primero complete los datos de contacto antes de emitir la O.C');
		}	
		
		
		
function cromalin(id)
{

    if(id >= 4)
    {
       
		//document.getElementById("dir").checked = true;
		document.getElementById("dir").disabled  = true;
		document.getElementById("dir").value  = 'SI';
		        
        return false;
    }else
    {
        //document.getElementById("dir").checked = false;
		document.getElementById("dir").disabled  = false;
		document.getElementById("dir").value  = 'NO';
        return false;
    }
}
	

function PiezasTotales(id)
{   
   // alert('id es '+id);
   
	var b = document.getElementById("unidades_por_pliego").value;
    //alert('id es '+b);
    if(id < b)
    {
		alert('Piezas totales en el pliego no puede ser menor a Unidades por pliego ');
		//document.piezas_totales_en_el_pliego.value = b;	
		document.getElementById("piezas_totales_en_el_pliego").value = b;
        return false;
    }	
}


 
/*
function validar_listado()
		{	
		//document.getElementById("div_condicion").style.display='block';
		//alert("I am an alert box! "+id);
		carga_ajax(webroot+'produccion/validar_listado_produccion','1','cuerpo_listado');		
		
		}
*/

function validar_listado()
		{	
		
		
				id2 =document.getElementById("modulo_lista").value;
				//carga_ajax(webroot+'produccion/validarListadoProduccionPorModulo',document.getElementById("nop").value,id2,'cuerpo_listado');		
				carga_ajax16(webroot+'produccion/validarListadoProduccionPorModulo',document.getElementById("nop").value,id2,document.getElementById("Buscar_estado").value,document.getElementById("vendedor").value,'cuerpo_listado');		
					
				if(id2=='Bodega Trato pegado')
				{        
					document.getElementById("titulo1").style.display='block';
					document.getElementById("desde").style.display='block';
					document.getElementById("hasta").style.display='block';
					document.getElementById("operadores").style.display='block';
					return false;
				}else{
					document.getElementById("titulo1").style.display='none';
					document.getElementById("desde").style.display='none';
					document.getElementById("hasta").style.display='none';
					document.getElementById("operadores").style.display='none';
					document.getElementById("Buscar_estado1").style.display='none';
					document.getElementById("Buscar_estado1").style.display='none';
					document.getElementById("vendedor1").style.display='none';
				}
				
				
				if(id2=='Listado Control Cartulina' || id2=='Listado Control Onda' || id2=='Listado Control Liner' || id2=='Listado Bobinado Cartulina')
				{        
					document.getElementById("Buscar_estado1").style.display='block';
					document.getElementById("vendedor1").style.display='block';
				
					return false;
				}
		
	}

	
	

function Parcial(id)
{
    
    if(id=='Parcial')
    {        
		document.getElementById("totaloparcial").style.display='block';
		
		document.getElementById("btnliberar").disabled = true;
		document.getElementById("btnparcial").disabled = false;
        return false;
    }else{
		document.getElementById("totaloparcial").style.display='none';
		
		document.getElementById("btnliberar").disabled = false;
		document.getElementById("btnparcial").disabled = true;
	}

}	



function validar_fechas_bodega()
		{	
				if(document.getElementById("modulo_lista").value =='Bodega Trato pegado')
				{        
			      carga_ajax16(webroot+'produccion/validarListadoProduccionPorModulo',document.getElementById("fecha1").value,document.getElementById("modulo_lista").value,document.getElementById("fecha2").value,document.getElementById("operador").value,'cuerpo_listado');		
			
					
					return false;
				}else{
				
				}
		
		}



//control cartulina Estado seleccion de gramaje
function ControlGranajeSeleccionado(id)
{
  //carga_ajax(webroot+'produccion/BuscarKilosCartulina',id,document.getElementById("gramaje_seleccionado").value,'hola');	
	   carga_ajax15(webroot+'produccion/BuscarKilosCartulina',id,document.getElementById("gramaje_seleccionado").value,document.getElementById("ancho_seleccionado_de_bobina").value,'hola');			
}	


//control onda Estado seleccion de gramaje
function ControlGramajeSeleccionadoOnda(id)
{
	    //alert('id es '+document.getElementById("gramaje_seleccionado").value);
	  //carga_ajax(webroot+'produccion/BuscarKilosOnda',id,document.getElementById("gramaje_seleccionado").value,'hola');	
      carga_ajax15(webroot+'produccion/BuscarKilosOnda',id,document.getElementById("gramaje_seleccionado").value,document.getElementById("ancho_seleccionado_de_bobina").value,'hola');			
}	

//control Liner Estado seleccion de gramaje
function ControlGramajeSeleccionadoLiner(id)
{
	    //alert('id es '+document.getElementById("gramaje_seleccionado").value);
	  //carga_ajax(webroot+'produccion/BuscarKilosOnda',id,document.getElementById("gramaje_seleccionado").value,'hola');	
      carga_ajax15(webroot+'produccion/BuscarKilosLiner',id,document.getElementById("gramaje_seleccionado").value,document.getElementById("ancho_seleccionado_de_bobina").value,'hola');			
}






function ValidarPegado(id)
{
    
    if(id=='NO')
    {        
		document.getElementById("lleva_aletas").style.display="block";
		document.getElementById("doblado").style.display="block";
		document.getElementById("empaquetado").style.display="block";
		document.getElementById("tamano_pieza_a_empaquetar").style.display="block";
		
		document.getElementById("adhesivo").style.display="none";
		document.getElementById("total_aplicaciones_adhesivo").style.display="none";
		document.getElementById("pegado_manual").style.display="none";
		document.getElementById("pegado_puntos").style.display="none";
		document.getElementById("cm_pegado_puntos").style.display="none";
		document.getElementById("tipo_fondo").style.display="none";
		document.getElementById("es_para_maquina").style.display="none";
		
		

    }else{
	    document.getElementById("lleva_aletas").style.display="none";
		document.getElementById("doblado").style.display="none";
		document.getElementById("empaquetado").style.display="none";
		document.getElementById("tamano_pieza_a_empaquetar").style.display="none";
		
		
		document.getElementById("adhesivo").style.display="block";
		document.getElementById("total_aplicaciones_adhesivo").style.display="block";
		document.getElementById("pegado_manual").style.display="block";
		document.getElementById("pegado_puntos").style.display="block";
		document.getElementById("cm_pegado_puntos").style.display="block";
		document.getElementById("tipo_fondo").style.display="block";
		document.getElementById("es_para_maquina").style.display="block";
		
	}

}	










	
		