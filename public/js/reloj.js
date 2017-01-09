//**************************************************
//mostrar reloj
	function muestraReloj()
        {
        // Compruebo si se puede ejecutar el script en el navegador del usuario
        if (!document.layers && !document.all && !document.getElementById) return;
        // Obtengo la hora actual y la divido en sus partes
        var fechacompleta = new Date();
        var horas = fechacompleta.getHours();
        var minutos = fechacompleta.getMinutes();
        var segundos = fechacompleta.getSeconds();
        var mt = "AM";
        // Pongo el formato 12 horas
        if (horas> 12) {
        mt = "PM";
        horas = horas - 12;
        }
        if (horas == 0) horas = 12;
        if(mt=="PM"){horas=horas+12;}
        // Pongo minutos y segundos con dos digitos
        if (minutos <= 9) minutos = "0" + minutos;
        if (segundos <= 9) segundos = "0" + segundos;
        // En la variable 'cadenareloj' puedes cambiar los colores y el tipo de fuente
        //cadenareloj = "<font size='-1' face='verdana'>" + horas + ":" + minutos + ":" + segundos + " " + mt + "</font>";
        cadenareloj =horas + ":" + minutos + ":" + segundos + " " + mt;
        // Escribo el reloj de una manera u otra, segun el navegador del usuario
        if (document.layers) {
        document.layers.spanreloj.document.write(cadenareloj);
        document.layers.spanreloj.document.close();
        }
        else if (document.all) spanreloj.innerHTML = cadenareloj;
        else if (document.getElementById) document.getElementById("spanreloj").innerHTML = cadenareloj;
        // Ejecuto la funcion con un intervalo de un segundo
        setTimeout("muestraReloj()", 1000);
        }