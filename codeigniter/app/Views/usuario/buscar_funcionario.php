
 <fieldset>
   <legend>ASOCIAR USUARIO A FUNCIONARIO </legend>
 <div class="row">

<div class="col-xs-12 col-md-3">
      <div class="input-group">
                      <span class="input-group-btn">
                      <button onclick="buscar_Funcionario()" type="button" class="btn btn-primary">
                      <i class="fa fa-search" aria-hidden="true"></i></button></span>
                      <input onkeydown="if(event.keyCode==13) busqueda_rapida();"   maxlength="13"   id="CEDULABUSCAR" placeholder="BUSCAR POR CEDULA"   type="text" class="form-control"  >
        </div>
        <!-- DATOS DEL FUNCIONARIO ASOCIADO --> 
        <input type="hidden" name="FUNCIONARIO"  >
</div>
<div class="col-xs-12 col-md-2">
    <div class="form-group">
      <input readonly  placeholder="CEDULA"  type="text" class="form-control"   id="CEDULA"  >
    </div>
</div>
<div class="col-xs-12 col-md-4">
    <div class="form-group"> 
      <input type="text" placeholder="NOMBRES" class="form-control"   id="NOMBRES" >
    </div> 
</div>
</div> <!--End row --> 

<!-- END  DATOS DEL FUNCIONARIO ASOCIADO --> 
 </fieldset>


 <script>

var searcherWindow= "";

function busqueda_rapida( IDPERSONA){
      let resourcePath="";

    if( IDPERSONA == undefined)
    {
      let cedu= $("#CEDULABUSCAR").val();
      if( cedu == "") return;
      resourcePath= "<?= base_url("funcionario/getJSON/CEDULA")?>/"+cedu;
    }else{
      resourcePath= "<?= base_url("funcionario/getJSON/IDNRO")?>/"+IDPERSONA;
    }
    $.ajax( {
    url: resourcePath,
    beforeSend: function(){
      $("#spinner_system").css("display", "block");
    },
    dataType: "json",
    success: function(res){ 
      $("#spinner_system").css("display", "none");
      if(  Object.keys( res ).length == 0 )
      {
        new PNotify({
                                  title: 'ERROR',
                                  text: 'EL NÚMERO DE CEDULA NO EXISTE',
                                  type: 'danger',
                                  styling: 'bootstrap3'
                              });  
        return;
      }
      //Mostrar CEDULA en form de credito
      let idnro= res.IDNRO; let cedula = res.CEDULA; let nom= res.NOMBRES; 
      $("input[name=FUNCIONARIO]").val( idnro);
      $("#CEDULA").val( cedula );
      $("#NOMBRES").val( nom );
      
    }, 
    error: function(){
      $("#spinner_system").css("display", "none"); 
    }
    }   );
}

function buscar_Funcionario(){

let url= "<?=base_url("funcionario/buscar_por_palabra")?>";
if( searcherWindow == ""  || searcherWindow.closed)
{
  searcherWindow= window.open( url, "FUNCIONARIOS", "width=400,height=300,resizable=no");
  searcherWindow.onbeforeunload= function(){
    if( this.IDClient  !=  "")
    busqueda_rapida(  this.IDClient);
  }
  }
else
searcherWindow.focus(); 
}


window.onbeforeunload= function(){ 
  if( searcherWindow !=  "")
  searcherWindow.close(); }  
 



 </script>