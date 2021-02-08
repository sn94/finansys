<?php

use App\Helpers\Utilidades;
?>
<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a style="font-weight: 600;" href="<?= base_url("prestamo/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp;  PRÉSTAMOS REGISTRADOS</a>


<div class="container p-2">
<h2 class="text-center prestyle">APROBACIÓN DE PRÉSTAMO<small></small></h2>
<div class="clearfix"></div>
</div>


<!-- INI FORM -->

<?php 
echo form_open("prestamo/aprobar", ['id'=> "aprobacion-form" , 'onsubmit'=>'aprobar(event)', 'class'=>'prestyle'])
?>
<input type="hidden" name="IDNRO" value="<?= $prestamo->IDNRO?>">
<input type="hidden" name="cabecera[ESTADO]" value="A">
<input type="hidden" name="cabecera[FUNCIONARIO_APROB]"  value="<?= session("ID")?>">


<div class="container">
  <button type="submit" class="btn btn-danger">GUARDAR TODO</button>
  </div>
  
<div class="row">


<div class="col-md-4">
<div class="form-group">
  <label for="ex3">CLIENTE:</label>
  <input readonly type="text" id="ex3" class="form-control" value="<?= $deudor->TIPO_PERSONA=="F" ?  $deudor->CEDULA : $deudor->RUC ?>">
  </div>

  <div class="form-group  ">
    <label for="ex3">NOMBRES:</label>
    <input readonly type="text" id="ex3" class="form-control" value="<?= $deudor->NOMBRES." ".$deudor->APELLIDOS?>">
  </div>

  <div class="form-group">
  <label for="ex4">MONTO A APROBAR:</label>
  <input readonly  value="<?= Utilidades::number_f( $monto->MONTO )?>"  type="text" id="ex4" class="form-control numero"  name="cabecera[MONTO_APROBADO]" >
  </div>

</div>


<div class="col-md-4">

               
  <div class="form-group ">
  <label for="ex4">FECHA DE ENTREGA:</label>
  <input  type="date" id="ex4" class="form-control"  name="cabecera[FECHA_ENTREGA]" >
  </div>
                 
  <div class="form-group ">
  <label for="ex4">FECHA INICIO COBRO:</label>
  <input onchange="generar_cuotas()"  type="date" class="form-control"  id="inicio-cobro" name="cabecera[FECHA_INI_COBRO]" >
  </div>

  <div class="form-group">
    <label >CATEGORÍA MONTO:</label> 
      <?= form_dropdown( "cabecera[CAT_MONTO]", $montos, !isset($prestamo_dato) ? "" :  $prestamo_dato->CAT_MONTO,['class'=> "select2_single form-control", 'onchange'=>'categoria_monto(event)' ] ) ?>   
    </div>

</div>



<div class="col-md-4">  <!-- CUOTAS --> 
 
  <div class="row">
    <div class="col-md-12">
    <div class="form-group">
        <label>FORMATO:</label>
        <?= form_dropdown( "", ["D"=>"DIARIO", "S"=>"SEMANAL", "Q"=>"QUINCENAL","M"=>"MENSUAL"], !isset($prestamo_dato) ? "" :  $prestamo_dato->FORMATO,[ 'id'=>'cate-formato', 'class'=> "select2_single form-control"  ] ) ?>   
    </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
      <label for="ex4">NRO.CUOTAS:</label>
      <input  id="cate-nro-cuo"  readonly type="text" id="ex4" class="form-control"  value="<?= $monto->NRO_CUOTAS?>" >
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
    <label for="ex4">CUOTA</label>
    <input  id="cate-cuotas" readonly type="text" id="ex4" class="form-control"  value="<?= $monto->CUOTA?>" >
    </div>
    </div>

  </div>

  
</div>

</div>
 
 
  <input type="hidden"  name="cabecera[FECHA_APROBACION]" id="fecha-aprobacion" value="<?=date("Y-m-j")?>">
 

 




<div id="dias-de-pago">
 
<div  class="checkbox">
<label class="">
<input onchange="generar_cuotas()" type="checkbox" value="1"   checked="checked"  > LUNES
</label>


<label class="">
<input onchange="generar_cuotas()"  type="checkbox" value="2"   checked="checked"  > MARTES
</label>
 
<label class="">
<input onchange="generar_cuotas()"  type="checkbox" value="3"   checked="checked"  > MIÉRCOLES
</label>
 
<label class="">
<input onchange="generar_cuotas()" type="checkbox" value="4"   checked="checked"  > JUEVES
</label>
 
<label class="">
<input onchange="generar_cuotas()"  type="checkbox" value="5"   checked="checked"  > VIERNES
</label>


<label class="">
<input  onchange="generar_cuotas()" type="checkbox" value="6"   checked="checked"  > SABADO
</label>
</div>

</div>


<div class="form-group col-md-3">  <button onclick="generar_cuotas()" type="button" class="btn btn-success">GENERAR CUOTAS</button>
</div>

  <table  id="cuotas" class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>MONTO</th>
                          <th>VENCIMIENTO</th> 
                          <th>DIA DE LA SEMANA</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                        
                      </tbody>
                    </table>





</form>








<script>



  function formato_cuotas( key){
    let num=1;
    switch(key){
      case "D": num=1;break;// Para Sumar un dia para generar la siguiente fecha de vencimiento
      case "S": num=7;break; //Para Sumar 7dias
      case "Q": num=15;break;// Para Sumar 15 dias
      case "M": num=30;break; // Para Sumar 30 dias
    } return num;
  }


   
  function es_bisiesto(nu) {
    if (parseInt(nu) % 4 == 0) {
        if (parseInt(nu) % 100 == 0) {
            if (parseInt(nu) % 400 == 0) {
                return true;
            } else return false;
        } else { return true; }
    } else return false;
}


function obtener_nombre_dia( dia){
  let dia_semana="DOMINGO";
  switch(  dia ){
        case 0: dia_semana= "DOMINGO"; break;
        case 1: dia_semana="LUNES"; break;
        case 2: dia_semana="MARTES"; break;
        case 3: dia_semana="MIERCOLES"; break;
        case 4: dia_semana="JUEVES"; break;
        case 5: dia_semana="VIERNES"; break;
        case 6: dia_semana="SABADO"; break;
      }  return dia_semana;
}

//Agrupa el numero de dias definidos para pago, ya sea Lunes = 1, Martes= 2, Miercoles= 3, etc.
function obtener_dias_pago(){
 let los_dias= document.querySelectorAll("#dias-de-pago input[type=checkbox]");
 let dias_permitidos= Array.prototype.filter.call( los_dias, function(ar){
   return  ar.checked;
 }). map( function(ar){  
    let numero_dia= parseInt(ar.value);
    return numero_dia;}
    );  
  
 return dias_permitidos;  
}

  function generar_cuotas(){
//Asegurar fecha cargada
    if(  $("#inicio-cobro").val() == "" ||   $("#inicio-cobro").val() == undefined ){
      alert("INDICAR FECHA DE INICIO DE COBRO PARA GENERAR LAS CUOTAS"); return false;
    }
//Asegurar dias de pago marcados
if(  obtener_dias_pago().length <= 0) { 
  alert("MARQUE AL MENOS UN DIA PARA LOS PAGOS"); 
  document.querySelector("#cuotas tbody").innerHTML= "";
  return false;
}
    $("#cuotas tbody").empty();
    let fecha_inicio=  $("#inicio-cobro").val();
    let montobase= $("#cate-monto").val();
    let nrocuotas= $("#cate-nro-cuo").val();
    let cuotas= $("#cate-cuotas").val();

  //convertir a fecha
  let fechaBase= Date.parse(   fecha_inicio );

    let  dia= 1;
    while(dia <=  nrocuotas){

      //Obtener dia mes anio
      let anio=   fechaBase.getFullYear(); 
      let mes= (fechaBase.getMonth()+1) < 10 ? "0"+(fechaBase.getMonth()+1) : (fechaBase.getMonth()+1);
      let diaa= (fechaBase.getDate()) < 10 ? "0"+(fechaBase.getDate()) : (fechaBase.getDate());
      let vencimiento=  anio+"-"+ mes+"-"+ diaa;
      let formato= formato_cuotas(  $("#cate-formato").val()  ) ;

      let showvencimiento="<input readonly type='date' name='vencimientos[]' value='"+vencimiento+"' >";
      let showcuotas="<input readonly type='hidden' name='montos[]' value='"+cuotas+"' >";

      //Dia de la semana en que cae el vencimiento
      let numeroDia= fechaBase.getDay(); // 1 2 3 4 5 6
      //Es uno de los dias marcados para PAGO ?
      let diasPermitidos= obtener_dias_pago();
    
      if( diasPermitidos.includes( numeroDia) ){

        let dia_semana=  obtener_nombre_dia( numeroDia );//Lunes, Martes, miercoles,etc ...
        $("#cuotas tbody").append("<tr><th scope='row'>"+dia+"</th><td>"+showcuotas+cuotas+"</td><td>"+showvencimiento+"</td><td>"+dia_semana+"</td></tr>");
         //Incrementar fecha
        fechaBase.setDate(  fechaBase.getDate()  + formato );//La siguiente fecha de vencimiento
        dia ++;// Seguir calculando pero para la siguiente cuota
        console.log( "DIA ", numeroDia);
      }else{
        //mantener el contador pero seguir 
        //Incrementando fecha hasta llegar a uno de los dias permitidos
        fechaBase.setDate(  fechaBase.getDate()  + 1 );
        console.log( "DIA no permitido ", numeroDia);
      }
    }
    return true;
  }


  function categoria_monto(e){
    //Muestra datos de monto, dias y cuota dependiendo de la opcion seleccionada
    let id_categoria_monto= e.currentTarget.value;
    get_custom( "<?=base_url("categoria_monto/get")?>/"+id_categoria_monto, function(res){
       let datos= JSON.parse( res);
       $("#cate-monto").val(numero_con_puntuacion( datos.MONTO)  );
       $("#cate-nro-cuo").val(datos.NRO_CUOTAS);
       $("#cate-cuotas").val(datos.CUOTA);
       $("#cate-formato").val(datos.FORMATO);

    });
  }




  function  aprobar(ev){
    ev.preventDefault();
    //Limpiar campos
let numeros= document.querySelectorAll(".numero");
Array.prototype.forEach.call( numeros, function(ar){
quitarSeparador(   ar  );
});

//VERIFICAR QUE LAS CUOTAS SE HAN GENERADO
let cuots= document.querySelector("#cuotas tbody").children;
if( cuots.length  == 0){ generar_cuotas(); return; }

ev.target.submit(); 
  }
 
</script>





<?= $this->endSection() ?>


