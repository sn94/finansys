 
 
<div class="container p-2">
<h2 class="text-center prestyle"> ARQUEO Y CIERRE DE CAJA<small></small></h2>
<div class="clearfix"></div>

</div>

<div class=" col-xs-12 col-md-offset-4 col-md-4"> 
<!-- INI FORM -->

<?php 
echo form_open("apeciecaja/arqueo_cierre", ['id'=> "cierre-form" , 'style'=>'padding: 5px;'])
?>
 
<input type="hidden" name="IDNRO" value="<?=session("APECAJA")?>">
<input type="hidden" name="CIERRE" value="<?=date("Y-m-d H:i:s")?>">



  
<div class="row">

  <div class="col-md-12">
    <div class="form-group  ">
        <label class="prestyle" for="ex3">CAJERO:</label>
        <input name="CAJERO" readonly type="text" id="ex3" class="form-control " value="<?= session("NICK")?>">
      </div>
  </div>

    <div class="col-md-12">
    <div class="form-group">
      <label for="ex3"  class="prestyle" >TOTAL EFECTIVO:</label>
      <input name="T_EFECTIVO" oninput="input_number_millares(event)"   type="text" id="ex3" class="form-control prestyle" value="0">
      </div> 
    </div>
 
    <div class="col-md-12">
    <div class="form-group">
      <label for="ex3"  class="prestyle">TOTAL CHEQUE:</label>
      <input name="T_CHEQUE" oninput="input_number_millares(event)"   type="text" id="ex3" class="form-control prestyle" value="0">
      </div> 
    </div>

    <div class="col-md-12">
    <div class="form-group">
      <label for="ex3"  class="prestyle">TOTAL TARJETA:</label>
      <input name="T_TARJETA" oninput="input_number_millares(event)"   type="text" id="ex3" class="form-control prestyle" value="0">
      </div> 
    </div>


    <div class="col-md-12"  >
  <button type="submit" class="btn btn-danger">CERRAR CAJA</button>
  </div>


</div>
  
</form>



</div>


