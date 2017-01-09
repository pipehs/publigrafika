 function dar_formato(num){  
 var cadena = ""; var aux;  
 var cont = 1,m,k;  
 if(num<0) aux=1; else aux=0;  
num=num.toString();  
 for(m=num.length-1; m>=0; m--){  
  cadena = num.charAt(m) + cadena;  
  if(cont%3 == 0 && m >aux)  cadena = "." + cadena; else cadena = cadena;  
  if(cont== 3) cont = 1; else cont++;  
 }  
 cadena = cadena.replace(/.,/,",");   
 return cadena;  
 }
