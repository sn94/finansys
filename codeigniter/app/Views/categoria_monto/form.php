<?php

use App\Helpers\Utilidades;
?>
<div class="row">

   
  <label >MONTO:</label>
  <input maxlength="10" oninput="input_number(event)" name="MONTO" type="text" class="form-control"  value="<?= !isset($dato) ? "" :   Utilidades::number_f($dato->MONTO)?>" >
  
  <label>NRO DE CUOTAS:</label>   
<input maxlength="10" oninput="input_number(event)" name="NRO_CUOTAS" type="text" class="form-control"  value="<?= !isset($dato) ? "" :   Utilidades::number_f($dato->NRO_CUOTAS)?>" >
 
 
  <label>CUOTA:</label>
  <input maxlength="10" oninput="input_number(event)" name="CUOTA" type="text" class="form-control"  value="<?= !isset($dato) ? "" :   Utilidades::number_f($dato->CUOTA)?>" >
  
  <label>FORMATO:</label>
  <select name="FORMATO" class="form-control">

    <option value="D">DIARIO</option>
    <option value="S">SEMANAL</option>
    <option value="Q">QUINCENAL</option>
    <option value="M">MENSUAL</option>
  </select>
 
  <label for="">%INTERÉS SOBRE CAPITAL:</label>
  <input type="text" name="INT_PORCE" readonly value="0.0"  class="form-control">


<?php if( !isset($vista)  ): ?>
  
<button type="submit" class="btn btn-primary">GUARDAR</button>
 
<?php  endif;?>

 


</div>

 <script>

   function calc_porce_interes(){
     let capital= $("input[name=MONTO]").val()=="" ? 0 : parseInt( quitarSeparador($("input[name=MONTO]").val()) );
     let cuota=   $("input[name=NRO_CUOTAS]").val()=="" ? 0 : parseInt( quitarSeparador($("input[name=NRO_CUOTAS]").val()) );
     let monto_cuot=  $("input[name=CUOTA]").val()=="" ? 0 : parseInt( quitarSeparador($("input[name=CUOTA]").val()) );
     let capital_f=   cuota * monto_cuot;
     let tot_int=   capital_f - capital;

     let interes_p=   (tot_int)/  (capital* cuota);
    let redondeo= new Intl.NumberFormat( "en", {maximumFractionDigits: 3, useGrouping: false }).format(  interes_p);
    $("input[name=INT_PORCE]").val( redondeo);
 
   

   }
 </script>