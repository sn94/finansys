<input type="hidden" name="IDNRO" value="<?= $OPERACION != "A" ?  $usuario_dato->IDNRO : "" ?>">


<div class="row">
  <div class="col">
    <?= view("usuario/forms/basico") ?>
  </div>
  <div class="col">
    <?= view("usuario/forms/permisos") ?>
  </div>
</div>

 




<script>
  function validarSeleccionPermisos(ev) {
    let usuario = ev.currentTarget.value;
    let opcion = usuario == "U";
    console.log(opcion);
    document.getElementById("supermarcador").disabled = !opcion;
    //SELECCIONAR TODO Y DESHABILITAR
    let checks = document.getElementById("permisos").children;
    Array.prototype.forEach.call(checks, function(item) {
      let columnas = item.children;
      columnas[1].firstChild.disabled = !opcion;
    });

  }


  function accionarCheckboxes(ev) {

    let opcion = ev.target.checked;

    let checks = document.getElementById("permisos").children;
    Array.prototype.forEach.call(checks, function(item) {
      let columnas = item.children;
      columnas[1].firstChild.checked = opcion;
    });
  }






  function habilitar_campo_pass(e) {
    if (e.target.checked)
      $("#pass1").removeAttr("disabled");
    else
      $("#pass1").attr("disabled", "true");
  }
</script>