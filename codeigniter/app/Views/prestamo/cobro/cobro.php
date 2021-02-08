<?php

use App\Helpers\Utilidades;
?>
<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>





<style>
  tr{ margin: 0px}
  td{
    padding-bottom:  0px !important;
    margin-bottom: 2px !important;
    font-weight: 600;
    color:#1d1d1d;
    font-size: 18px;
  }
  th{ font-size: 18px;}
</style>

 

<a class="btn btn-sm btn-primary" href="<?= base_url("prestamo/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp;  LISTA DE COBROS</a>


<div class="container" style="background-color: #2a3f54;margin-bottom: 2px;">
<h2 style="color: white;" class="text-center prestyle">COBROS - &nbsp;

  <span style="font-weight: 300;">Cliente: <?= $deudor->NOMBRES." ".$deudor->APELLIDOS ?></span>
  <span style="color:#80ffff;">(<?= Utilidades::number_f( $monto->MONTO )?> &nbsp;GS.)
  <?= $monto->CUOTA." X ".$monto->NRO_CUOTAS ?>
</span>
</h2>
<div class="clearfix"></div>
</div>


<div id="vista-form-cobro">
<?php  echo  view("prestamo/cobro/form");  ?>

</div>







<script>



function totalizar_importe(ev){


  let efec= quitarSeparador( document.getElementById("EFECTIVO").value );
  let chequ= quitarSeparador( document.getElementById("CHEQUE").value );
  let tarj= quitarSeparador( document.getElementById("TARJETA").value  );
  let tot=  parseInt( efec ) + parseInt(chequ) + parseInt(tarj);
 
 $("#TOTALIMPORTE").text(  numero_con_puntuacion(tot));
 input_number_millares(ev);
 calcular_cambio();
}


function totalizar(ev){

  let total= 0; 

  let checks= document.querySelectorAll("#cuotas input[type=checkbox]");
  let checks_marcados= Array.prototype.filter.call(   checks, function(ele){
    return ele.checked;
  }  );
   
  Array.prototype.forEach.call(  checks_marcados, function(elemento, indice){

    //sumar el Saldo de cada cuota
    let fila= elemento.parentNode.parentNode;
    let colSaldo= fila.children[3].firstChild;
    let Saldo=  quitarSeparador( colSaldo.textContent );
 

 //total+=  parseInt( quitarSeparador( $("#cate-cuotas").val())  );// REFERENCIA EL TOTAL DE LA CUOTA
 total+= parseInt( Saldo);//REFERENCIA EL SALDO DE LA CUOTA
   });
    
  $("#TOTALCOBRO").text( numero_con_puntuacion( total)   );
}

function marcacion(ev){
  let IDCUOTA=ev.currentTarget.value;
  let POSICION_ACTUAL= -1;

  if( ev.currentTarget.checked)//MARCADO
   { 

    //MARCAR LOS CHECKBOX SUPERIORES
    let checks= document.querySelectorAll("#cuotas input[type=checkbox]");
    Array.prototype.forEach.call(   checks, function(elemento, indice){
        if( elemento.value == IDCUOTA ) { POSICION_ACTUAL=  indice;    }
        if( POSICION_ACTUAL == -1){   elemento.checked= true;     }
    });

    }else{//CUANDO DESMARCA 
       
    POSICION_ACTUAL=-1;
    //DESMARCAR LOS CHECKBOX INFERIORES
    let checks= document.querySelectorAll("#cuotas input[type=checkbox]");
        Array.prototype.forEach.call(   checks, function(elemento, indice){
            if( elemento.value == IDCUOTA ){     POSICION_ACTUAL=  indice;        }
            if( POSICION_ACTUAL != -1){    elemento.checked= false;    }
        });
    }
    totalizar(ev);
}

  

  function formato_cuotas( key){
    let num=1;
    switch(key){
      case "D": num=1;break;
      case "S": num=7;break;
      case "Q": num=15;break;
      case "M": num=30;break;
    } return num;
  }


 

function calcular_cambio(){
  let total=  quitarSeparador(  $("#TOTALCOBRO").text()  );
  //importe
  let efec= quitarSeparador( document.getElementById("EFECTIVO").value );
  let chequ= quitarSeparador( document.getElementById("CHEQUE").value );
  let tarj= quitarSeparador( document.getElementById("TARJETA").value  );
  let tot=  parseInt( efec ) + parseInt(chequ) + parseInt(tarj);

  //Cambio
  let cambio=0;
  if(  tot > parseInt(total) )
  cambio=  tot -  parseInt(total);
  document.getElementById("SALDO").textContent= cambio;
}
 
async function guardarCobro(ev, permitir ){

ev.preventDefault(); 
if(permitir==undefined)  permitir= false;
 
//Limpiar campos
let numeros= document.querySelectorAll(".numero");
Array.prototype.forEach.call( numeros, function(ar){
quitarSeparador(   ar  );
});

 
$.ajax({
url:  ev.target.action, 
data:   $(ev.target).serialize(), 
method: "post", 
success: function(res){  
      $("#vista-form-cobro").html( res );//,Mostrar estado de cuenta de cliente
        //aCTUALIZAR VISTA  A COBRADO, MOSTRAR SALDO
        //let idCliente= $("#DEUDOR").val();
     //  mostrarSaldoDeudaCliente( idCliente );

 }
});
//ev.target.submit( );
 
}



//funcion MUESTRA RESUMEN DEL ESTADO
//DE CUENTA DEL CLIENTE, CON OPCION DE IMPRIMIR ATRAVES DE 
//UN ENLACE
function mostrarSaldoDeudaCliente( idCliente){
  let urlCOBRADO= "<?=base_url('deudor/sumas_saldos')?>/"+idCliente;
$.ajax({
  url: urlCOBRADO,
  success: function(html){ $("#vista-form-cobro").html(  html);   }
});
 
}


//FUNCION IMPRIMIR RECIBO 
//RECIBE EL ID DE RECIBO
//O INTERPRETA EL PARAMETRO COMO UNA URL A SOLICITAR
async function printBill( ID_RECIBO){

  if( typeof ID_RECIBO == "object")
  ID_RECIBO.preventDefault();//prevenir evento 
  
let urlBill= "";
if( typeof ID_RECIBO == "object")
urlBill=  ID_RECIBO.currentTarget.href;
else 
urlBill=  "<?=base_url('prestamo/mostrarRecibo')?>/"+ID_RECIBO;
 
$.ajax({
  url: urlBill,
  success: function(html){
  //print
  let documentTitle="PAGOS" ;
var ventana = window.open( "", 'PRINT', 'height=400,width=600');
ventana.document.write( html ); 
  ventana.document.close(); 
  ventana.focus();
  ventana.print();
  ventana.close();
  }
});
}
 

 




 
</script>





<?= $this->endSection() ?>


