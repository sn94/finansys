<?php

use App\Helpers\Utilidades;
?>
<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>

<h2 class="text-center prestyle">INFORMES - CUOTAS</h2>

<?php 
echo form_open("prestamo/informes_cuotas", ['id'=> "cuotas-informe", "class"=>"form-inline prestyle", 'onsubmit'=>'buscar(event)' ])
?>

<!--Ini row --> 
<div class="row">

    <div class="col-xs-12 col-md-6">
        <fieldset  >
            <legend >Por fecha de vencimiento</legend> 
        <div class="form-group">
        <label style="font-size: 10pt; font-weight: 600; ">Desde:</label> 
        <input class="form-control form-control-sm" type="date" id="Desde" onchange="limpiar_x_fecha_pago()" name="Desde"> 
        </div>

        <div class="form-group">
        <label style="font-size: 10pt; font-weight: 600;">Hasta: </label>
        <input class="form-control form-control-sm"  type="date" id="Hasta" onchange="limpiar_x_fecha_pago()"  name="Hasta" >
        </div>
        </fieldset>
    </div>
    <div class="col-xs-12 col-md-6">
        <!--Filtro fecha de pago -->
        <fieldset>  
        <legend>Por fecha de pago</legend> 

        <div class="form-group">
        <label style="font-size: 10pt; font-weight: 600; ">Desde:</label> 
        <input class="form-control form-control-sm" type="date"  onchange="limpiar_x_fecha_ven();limpiar_x_estado_pago();" name="DesdePago"> 
        </div>

        <div class="form-group">
        <label style="font-size: 10pt; font-weight: 600;">Hasta: </label>
        <input class="form-control form-control-sm"  type="date" onchange="limpiar_x_fecha_ven();limpiar_x_estado_pago();"   name="HastaPago" >
        </div>
        </fieldset>
    </div>
</div><!--End row --> 


<!--Ini row --> 
<div class="row">

    <div class="col-xs-12 col-md-6">
        <!-- filtro por cuotas vencidas y no vencidas-->
        <fieldset>
            <legend>Por estado de vencimiento</legend>
            <div  class="radio">
        <label class="">
        <input type="radio" value="T"    name="vencidas"  > TODAS
        </label>
        <label class="">
        <input type="radio" value="S"     name="vencidas"  > VENCIDAS
        </label>
        <label class="">
        <input type="radio" value="N"     name="vencidas"  > POR VENCER
        </label>
        </div>
        </fieldset>
    </div>
    <div class="col-xs-12 col-md-6">
        <!-- Filtro por estado de pago  cobradas y no cobradas -->
        <fieldset>
            <legend>Por estado de pago </legend>
            <div  class="radio">
        <label class="">
        <input type="radio" value="T"   name="cobradas"  > TODAS
        </label>
        <label class="">
        <input type="radio" value="PA"     name="cobradas"  > PAGADAS
        </label>
        <label class="">
        <input type="radio" value="PE"   name="cobradas"  > PENDIENTES
        </label>
        </div>
        </fieldset>
    </div>
</div><!--End row --> 

 



 <button style="background-color: #a3c5fc;color: #1a0c00;" type="submit" class="btn btn-sm btn-info mt-1">BUSCAR</button>
  
  <a onclick="downloadPDF(event)" href="#"><img src="<?=base_url("assets/img/pdf_icon.png")?>" alt=""> PDF</a>
  <a href="#" onclick="downloadEXCEL(event)"><img src="<?=base_url("assets/img/excel_icon.png")?>" alt=""> Excel</a>
</form> 


<div id="grilla">

<?php echo view("prestamo/informes/cuotas_grilla"); ?>
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
    let pdfDownloadLink= $("#cuotas-informe").attr("action")+"/PDF";
    let originalFormAction= $("#cuotas-informe").attr("action");
    //agregar un target
    $("#cuotas-informe").attr("target", "_blank");
    $("#cuotas-informe").attr("action", pdfDownloadLink);
   document.getElementById("cuotas-informe").submit();
    $("#cuotas-informe").removeAttr("target");
    $("#cuotas-informe").attr("action", originalFormAction);

    }

    function downloadEXCEL(ev){
    ev.preventDefault();
    let xlsDownloadLink= $("#cuotas-informe").attr("action")+"/JSON";
    
    $.ajax({ 
        url: xlsDownloadLink, 
    data: $("#cuotas-informe").serialize(), 
    method: "post", success: function( json){
        console.log(  json );
        callToXlsGen_with_data( "CUOTAS", json );
    } });
    }



    function limpiar_x_fecha_pago(){
        $("#cuotas-informe input[name=DesdePago], #cuotas-informe input[name=HastaPago]").val("");
        $(" input[name=vencidas]").prop("checked", false);
    }


    function limpiar_x_fecha_ven(){
        $("#cuotas-informe input[name=Desde], #cuotas-informe input[name=Hasta]").val("");
        $(" input[name=vencidas]").prop("checked", false);
    }

    function limpiar_x_estado_pago(){
        $(" input[name=cobradas]").prop("checked", false);
    }

</script>

<?= $this->endSection() ?>
