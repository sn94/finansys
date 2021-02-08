 
<script type="text/javascript">
   
   function abrir_Caja(ev){
     ev.preventDefault(); 
     if(  $("#SALDO_INI").val() == "" || $("#SALDO_INI").val() == "0")  {  alert("FALTA EL MONTO INICIAL"); return;}
     ev.target.submit();
   }
  
 </script>
 
<div class="container p-2">
<h2 class="text-center prestyle"> APERTURA DE CAJA <small></small></h2>
<div class="clearfix"></div>
</div>



<div class="col-xs-12 col-md-offset-4 col-md-4">

<!-- INI FORM -->

<?php 
echo form_open("apeciecaja/apertura", ['id'=> "apertura-form" , 'style'=>'padding: 5px;', 'onsubmit'=>'abrir_Caja(event)']);
?>
 
<input type="hidden" name="CAJERO" value="<?=session("ID")?>">
<input type="hidden" name="APERTURA" value="<?=date("Y-m-d H:i:s")?>">




  
<div class="row">

<div class="col-md-12">
<div class="form-group">
  <label class="prestyle" >CAJA:</label>
    <?= form_dropdown( "CAJA", $cajas, NULL,['class'=> "select2_single form-control prestyle" ] ) ?>
</div>
</div>

  <div class="col-md-12">
    <div class="form-group  ">
        <label for="ex3"  class="prestyle">CAJERO:</label>
        <input   name="CAJERO" readonly type="text" id="ex3" class="form-control prestyle" value="<?= session("NICK")?>">
      </div>
  </div>

    <div class="col-md-12">
    <div class="form-group">
      <label for="ex3"  class="prestyle">SALDO INICIAL:</label>
      <input id="SALDO_INI" name="SALDO_INI" oninput="input_number_millares(event)"   type="text" id="ex3" class="form-control prestyle" value="0">
      </div> 
    </div>
 
    <div class="col-md-12"  >
  <button type="submit" class="btn btn-danger">ABRIR</button>
  </div>


</div>
  
</form>


</div>