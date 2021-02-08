<?php

use App\Helpers\Utilidades;
?>

<!DOCTYPE html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
 
@media print{
   

    body{
       
        margin-top: 1cm;
        print-color-adjust: exact;
        color-adjust: exact; 
     color: #404040;
     font-family: Arial, Helvetica, sans-serif;
 }

#cabecera, #cuerpo, #container{
            width: 200pt;
}
 
#container{
    border: 1mm solid #a3a3a3;
    
}

}


 
@page 
    {
        size:  auto;   /* auto es el valor inicial */ 
        margin: 0mm;  /* afecta el margen en la configuración de impresión */
        margin-left: 1cm;
        margin-right: 1cm;
    }

 
 body{
    margin-top: 1cm;
     color: #404040;
     font-family: Arial, Helvetica, sans-serif;
 }

#cabecera, #cuerpo, #container{
            width: 21cm;
}

#container{
    padding-top: 10px;
    border: 1mm solid #a3a3a3;
  
}
        </style>
    </head>
    <body >



<div id="container">

            
    <div id="cabecera">
   <table style="width: 21cm;">
       <tr ><td style="padding:0px;margin:0px;"><h2 style="margin:0px;">RECIBO N° <?=$NRORECIBO?> </h2></td>
       <td style="width: 150px;"></td>
       <td style="background-color: #d2d2d2; border: 1px solid #aeaeae; font-size: 20px;" > G.  <?=  Utilidades::number_f($IMPORTE)?> </td></tr>
   </table>

    </div>

    <div id="cuerpo">
    <p style="text-align: right;"><?=$FECHA_LETRAS?></p>
        <p>Recibí(mos) de <span style="background-color: #d2d2d2;  border: 1px solid #aeaeae; font-size: 14px;text-align: right;padding-left:15px;padding-right:15px;"> <?=$CLIENTE?> </span> </p>
        <p>la cantidad de guaraníes <span style="background-color: #d2d2d2; border: 1px solid #aeaeae; font-size: 14px;padding-left:15px;padding-right:15px;"> <?=$IMPORTE_LETRAS?></span> </p>
        <p>por concepto de <span style="background-color: #d2d2d2;   border: 1px solid #aeaeae; font-size: 14px;padding-left:15px;padding-right:15px;">  <?=$CONCEPTO?> </span>  </p>
       
    </div>
    <table style="width: 21cm;">
       <tr ><td> </td>
       <td style="width: 15cm;"></td>
       <td style=" border-top: 1px solid #070707; font-size: 14px; ">Firma y aclaración</td></tr>
   </table>


            </div>
    </body>
</html> 