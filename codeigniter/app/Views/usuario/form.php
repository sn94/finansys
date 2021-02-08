
<?php 
if( isset($ADICIONAL) ):
  ?> 
  <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong><?= $ADICIONAL ?></strong>
</div>
<?php
endif;
?>



  <input type="hidden" name="IDNRO"  value="<?= $OPERACION != "A" ?  $usuario_dato->IDNRO : "" ?>">


  <!--buscador de funcionarios --> 

<?php  if(  $OPERACION == "A"): 
  
  echo view("usuario/buscar_funcionario");

 endif;?>



  




<fieldset>
  <legend>DATOS DE ACCESO</legend>
  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">NICK <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input maxlength="25"  value="<?= !isset($usuario_dato) ? "" :   $usuario_dato->NICK?>"  name="NICK" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
</div>
               
<div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">ROL</label>
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                          <?= form_dropdown( "ROL", ["A"=>"ADMINISTRADOR", "C"=>"COBRADOR", "U"=>"OTRO USUARIO" ], !isset($usuario_dato) ? "A" :  $usuario_dato->ROL,[ 'id'=>'ROL', 'class'=> "select2_single form-control col-md-7 col-xs-12 ", 'onchange'=>'validarSeleccionPermisos(event)'  ] ) ?>   
                        </div>
</div>
                    
<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">PASSWORD <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input disabled type="password" id="pass1" name="PASS" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
</div>


<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Editar password <span class="required">*</span>
                        </label>
                        <div class="col-md-1 col-sm-1 col-xs-1">
                        <div class="checkbox">
                            <label>
                            <input  type="checkbox" onchange="habilitar_campo_pass(event)" class="form-control col-md-7 col-xs-12" >
                            </label>
                          </div>   
                        </div>
</div>
                       
 

<?php if( isset($OPERACION) && $OPERACION!="V"  ): ?>
                        <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-success">GUARDAR</button>
                        </div>
                      </div>
<?php  endif;?>
 
<div class="ln_solid"></div>
</fieldset>
                      


<fieldset>
  <legend>PERMISOS</legend>
  <div class="table-responsive">

  <table class="table">
    <thead>
      <tr><th>NOMBRE PERMISO</th>  <th> <input disabled type="checkbox"  onchange="accionarCheckboxes(event)" id="supermarcador"></th></tr>
    </thead>

    <tbody id="permisos">

    <?php  foreach( $permisos as $it):  ?>

      <tr><td><?= $it->PERMISO?> </td>  <td><input disabled style="transform: scale(2);" type="checkbox" name="PERMISO[]" value="<?= $it->IDNRO ?>"></td></tr>
    <?php  endforeach; ?>

    </tbody>
  </table>

  </div>
</fieldset>
                     
<script>


function validarSeleccionPermisos(ev){
  let usuario= ev.currentTarget.value;
  let opcion= usuario == "U";
  console.log(  opcion);
    document.getElementById("supermarcador").disabled= !opcion;
    //SELECCIONAR TODO Y DESHABILITAR
    let checks= document.getElementById("permisos").children;
    Array.prototype.forEach.call( checks, function(item){
                let columnas= item.children;
                columnas[1].firstChild.disabled=  !opcion;
            });
  
}


function accionarCheckboxes(ev){

  let opcion=  ev.target.checked;

    let checks= document.getElementById("permisos").children;
    Array.prototype.forEach.call( checks, function(item){
                let columnas= item.children;
                columnas[1].firstChild.checked=  opcion;
            });
}





 
function habilitar_campo_pass(e){
  if(e.target.checked)
$("#pass1").removeAttr("disabled");
else
$("#pass1").attr("disabled", "true");
}



</script>
