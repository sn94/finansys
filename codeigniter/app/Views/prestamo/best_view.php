<?php
                      $deudorForm=   $OPERACION=="A" ? "deudor/create" : "deudor/edit";
                      $garanteForm=   $OPERACION=="A" ? "garante/create" : "garante/edit";
                      $prestamoForm=   $OPERACION=="A" ? "prestamo/create" : "prestamo/edit";
                      ?>


<div id="wizard_verticle" class="form_wizard wizard_verticle">
                      <ul class="list-unstyled wizard_steps anchor">
                        <li>
                          <a href="#step-11" class="done selected" isdone="1" rel="1">
                            <span class="step_no">1</span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-22" class="done" isdone="1" rel="2">
                            <span class="step_no">2</span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-33" class="done" isdone="1" rel="3">
                            <span class="step_no">3</span>
                          </a>
                        </li>
                      
                      </ul>

                      
                      
                      
                      
                    <div class="stepContainer" style="height: 472px;"><div id="step-11" class="content" style="display: none;">
                        <h2 class="StepTitle prestyle">Datos del solicitante</h2>
                        
                        <!-- INI FORM -->
                                    
                    <div class="input-group">
                    <span class="input-group-btn">
                    <button onclick="buscar_Clientes()" type="button" class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i></button></span>
                    <input onkeydown="if(event.keyCode==13) buscar_Cedula();"   maxlength="13"   id="CEDULABUSCAR" placeholder="BUSCAR POR CEDULA o RUC"   type="text" class="form-control"  >
                  </div>
                  <a class="btn btn-warning" href="#" onclick="habilitarFormSolicitante()"><i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; CARGAR NUEVO</a>
                  <?php 
                  echo form_open_multipart( $deudorForm, 
                  ['id'=> "form-1", "style"=>"padding-left: 10px;", "onsubmit"=>"guardarform1(event)",
                  "class"=> "form-horizontal   container prestyle" ])
                  ?> 

                  <button id="form-1-reset" type="reset"   style="display: none;"></button>
                      <div id="vista-form-1">
                      <?php echo view('deudor/form'); ?>
                      </div>
                      
                  </form>
  

                      </div>
                      
                      <div id="step-22" class="content" style="display: block;">
                        <h2 class="StepTitle">Datos de Garante</h2>


                        <!--SEARCH --> 
              <div class="input-group">
                    <span class="input-group-btn">
                    <button onclick="buscar_Garante()" type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button></span>
                    <input   maxlength="8"   oninput="input_number(event)" id="CEDULABUSCAR_2" placeholder="BUSCAR CEDULA"   type="text" class="form-control"  >
                  </div>

                            <!-- INI FORM -->
                  <?php 
                  echo form_open_multipart( $garanteForm, 
                  ['id'=> "form-2", "style"=>"padding-left: 10px;", "onsubmit"=>"guardarform2(event)",
                  "class"=> "form-horizontal   container prestyle" ])
                  ?>  
                      <div id="vista-form-2">
                      <?php echo view('garante/form'); ?> 
                      </div>      
                 

                    </form>
                            
                        

                      </div><div id="step-33" class="content" style="display: none;">
                        <h2 class="StepTitle prestyle">Crédito</h2>

                        <?php 
                  echo form_open( $prestamoForm, 
                  ['id'=> "form-3", "style"=>"padding-left: 10px;", "onsubmit"=>"guardarform3(event)",
                  "class"=> "form-horizontal   container prestyle" ])
                  ?>  
                 

                        <?php echo view("prestamo/form",array("montos"=> $montos)); ?> 
                        </form>

                      </div> </div>
                 <!--   <div class="actionBar">
                        <div class="msgBox"><div class="content"></div><a href="#" class="close">X</a></div>
                        <div class="loader">Loading</div>
                        <a href="#" class="buttonFinish buttonDisabled btn btn-default">Finish</a>
                        <a href="#" class="buttonNext btn btn-success">Next</a>
                        <a href="#" class="buttonPrevious btn btn-primary">Previous</a></div> -->
                      </div>




<script>

var searcherWindow= "";

function guardarform1(e){

  guardar( e, function(res){ 
    
    let mensaje= JSON.parse(res); 
    if( "error" in mensaje ) {alert(  mensaje.error); return ; }

    $("#form-1 input[name=IDNRO]").val( mensaje.IDNRO );//En el formulario de datos personales
    $("#form-3 input[name=DEUDOR]").val( mensaje.IDNRO );//En el formulario de credito
    //nOMBRE Y CEDULA en form de credito
    $("#CI_TITULAR").val(   $("#form-1 input[name=CEDULA]").val() ); 
    $("#TITULAR_NOMBRES").val(   $("#form-1 input[name=NOMBRES]").val()+" "+ $("#form-1 input[name=APELLIDOS]").val() ); 
    habilitarCampos( "form-2" , true);//habilitar form de garante
    habilitarCampos( "form-3" , true);//habilitar form de credito
    new PNotify({  title: 'GUARDADO',        text: '',  type: 'success',  styling: 'bootstrap3'  });    
    } );
  
}

function guardarform2(e){

guardar( e, function(res){ 
  
  let mensaje= JSON.parse(res);  
  $("#form-2 input[name=IDNRO]").val( mensaje.IDNRO );//En el formulario de garante
    $("#form-3 input[name=GARANTE]").val( mensaje.IDNRO );//En el formulario de credito
     //nOMBRE Y CEDULA en form de credito
     $("#CI_GARANTE").val(   $("#form-2 input[name=CEDULA]").val() ); 
    $("#GARANTE_NOMBRES").val(   $("#form-2 input[name=NOMBRES]").val()+" "+ $("#form-2 input[name=APELLIDOS]").val() ); 

  new PNotify({  title: 'GARANTE GUARDADO',        text: '',  type: 'success',  styling: 'bootstrap3'  });    } )

}

function guardarform3(e){
  clean_numbers( "#form-3");
guardar( e, function(res){ 
  
  let mensaje= JSON.parse(res); 
  $("#form-3 input[name=IDNRO]").val( mensaje.IDNRO );
  rec_formato_numerico("#form-3");
  new PNotify({  title: mensaje.MENSAJE,        text: '',  type: 'success',  styling: 'bootstrap3'  });    } )

}


function buscar_Clientes(){

let url= "<?=base_url("deudor/buscar_por_palabra")?>";
if( searcherWindow == ""  || searcherWindow.closed)
{
  searcherWindow= window.open( url, "BUSCADOR DE CLIENTES", "width=400,height=300,resizable=no");
  searcherWindow.onbeforeunload= function(){
    if( this.IDClient  !=  "")
    buscar_Cedula(  this.IDClient);
  }
  }
else
searcherWindow.focus(); 
}

function buscar_Cedula( IDCLIENTE ){
  let resourcePath="";

  if( IDCLIENTE == undefined)
  {
    let cedu= $("#CEDULABUSCAR").val();
    if( cedu == "") return;
    resourcePath= "<?= base_url("deudor/get")?>/"+cedu;
  }else{
    resourcePath= "<?= base_url("deudor/get/IDNRO")?>/"+IDCLIENTE+"/M";
  }
  $.ajax( {


    url: resourcePath,
    beforeSend: function(){
      $("#vista-form-1").html( "<img src='<?= base_url("assets/img/loading.gif")?>'>" );
    },
    success: function(res){
      $("#vista-form-1").html( res );
      //Mostrar CEDULA en form de credito
      let idnro= $("#form-1 input[name=IDNRO]").val(); 
      let cedula =$("#form-1 input[name=CEDULA]").val() == undefined ? $("#form-1 input[name=RUC]").val() : $("#form-1 input[name=CEDULA]").val();
      let nom= $("#form-1 input[name=NOMBRES]").val();
      let ape=$("#form-1 input[name=APELLIDOS]").val()==undefined? "": $("#form-1 input[name=APELLIDOS]").val() ;
      $("#form-3 input[name=DEUDOR]").val( idnro);
      $("#CI_TITULAR").val( cedula );
      $("#TITULAR_NOMBRES").val(nom+" "+ape);
      habilitarCampos("form-1", false);
      habilitarCampos( "form-2" , true);//habilitar form de garante
      habilitarCampos( "form-3" , true);//habilitar form de credito
    }, 
    error: function(){
      $("#vista-form-1").html( "Error al recuperar datos" );
    }
  }   );
}

function buscar_Garante(){
  let cedu= $("#CEDULABUSCAR_2").val();
  if( cedu == "") return;
  $.ajax( {

    url: "<?= base_url("garante/get")?>/"+cedu,
    beforeSend: function(){
      $("#vista-form-2").html( "<img src='<?= base_url("assets/img/loading.gif")?>'>" );
    },
    success: function(res){
      $("#vista-form-2").html( res );
        //Mostrar CEDULA en form de credito
        let idnro= $("#form-2 input[name=IDNRO]").val(); 
        let cedula =$("#form-2 input[name=CEDULA]").val();
      let nom= $("#form-2 input[name=NOMBRES]").val();
      let ape=$("#form-2 input[name=APELLIDOS]").val();
      $("#CI_GARANTE").val( cedula );
      $("#GARANTE_NOMBRES").val(nom+" "+ape);
      $("#form-3 input[name=GARANTE]").val( idnro);
    }, 
    error: function(){
      $("#vista-form-2").html( "Error al recuperar datos" );
    }
  }   );
}



//Al hacer clic en el boton de edicion, se omite la busqueda por cedula o ruc, para cargar un registro de solicitante
//desde cero
function habilitarFormSolicitante(){
  habilitarCampos("form-1", true);
  cleanForm( "form-1"); cleanForm( "form-3");
  $("#CEDULABUSCAR").val("");

}
window.onload= function(){
  $("div.stepContainer.content").css("width", "100%");
      $("div.stepContainer.content").css("height", "100%");
      habilitarCampos( "form-1" , false);
      habilitarCampos( "form-2" , false);
      habilitarCampos( "form-3" , false);
    }
window.onbeforeunload= function(){ 
  if( searcherWindow !=  "")
  searcherWindow.close(); }
</script>