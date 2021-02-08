<?php

use App\Helpers\Utilidades;
?>
<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>

<h2 class="text-center prestyle">INFORMES - CAPITAL Y SALDOS</h2>

<?php 
echo form_open("prestamo/informes_capital_interes", ['id'=> "saldos-informe", "class"=>"form-inline prestyle", 'onsubmit'=>'buscar(event)' ])
?>

<div class="form-group">
<label style="font-size: 10pt; font-weight: 600; ">Desde:</label> 
<input class="form-control form-control-sm" type="date" id="Desde" name="Desde"> 
</div>

<div class="form-group">
<label style="font-size: 10pt; font-weight: 600;">Hasta: </label>
 <input class="form-control form-control-sm"  type="date" id="Hasta" name="Hasta" >
</div>
 
 <button style="background-color: #a3c5fc;color: #1a0c00;" type="submit" class="btn btn-sm btn-info mt-1">BUSCAR</button>
  
  <a onclick="downloadPDF(event)" href="#"><img src="<?=base_url("assets/img/pdf_icon.png")?>" alt=""> PDF</a>
  <a href="#" onclick="downloadEXCEL(event)"><img src="<?=base_url("assets/img/excel_icon.png")?>" alt=""> Excel</a>
</form> 


<div id="grilla">

<?php echo view("prestamo/informes/informes_capi_saldos_grilla"); ?>
</div>

<script>


  async  function buscar(ev){
    ev.preventDefault();
    $.ajax({
        url: ev.target.action,
        method: "post",
        data: $(ev.target).serialize(),
        beforeSend: function(){
            $("#grilla").html( "<img  src='<?=base_url("assets/img/spinner.gif")?>' />");
        } ,
        success: function( respuesta){
            $("#grilla").html(  respuesta);
        },
        error: function( xhr, textstatus){
            $("#grilla").html(  textstatus);
        }
    }); 

    }




  function downloadPDF(ev){
    ev.preventDefault();
    let pdfDownloadLink= $("#saldos-informe").attr("action")+"/PDF";
    let originalFormAction= $("#saldos-informe").attr("action");
    //agregar un target
    $("#saldos-informe").attr("target", "_blank");
    $("#saldos-informe").attr("action", pdfDownloadLink);
   document.getElementById("saldos-informe").submit();
    $("#saldos-informe").removeAttr("target");
    $("#saldos-informe").attr("action", originalFormAction);

    }

    function downloadEXCEL(ev){
    ev.preventDefault();
    let xlsDownloadLink= $("#saldos-informe").attr("action")+"/JSON";
    
    $.ajax({ 
        url: xlsDownloadLink, 
    data: $("#saldos-informe").serialize(), 
    method: "post", success: function( json){
        console.log(  json );
        callToXlsGen_with_data( "COBROS", json );
    } });
    }


</script>

<?= $this->endSection() ?>
