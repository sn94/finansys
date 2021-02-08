<style>
  fieldset {
    border: 1px solid #9999ca;
    border-radius: 20px;
    padding-bottom: 5px;
    margin-bottom: 2px;
    width: 100%;
    height: 100%;
  }

  fieldset legend {
    padding-left: 5px;
    padding-top: 2px;
    border-radius: 12px 12px 0px 0px;
    background-color: #8eb9b5;
    color: white;
    text-shadow: 1px 1px 8px #04043c;
    font-size: 11pt;
    font-weight: 600;
  }

  fieldset label.sobrio {
    text-transform: capitalize;
    font-size: 9pt;
    font-weight: 600;
    color: #4d4d4d;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
  }
</style>



<?php
if (isset($ADICIONAL)) :
?>
  <div class="alert alert-warning alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <strong><?= $ADICIONAL ?></strong>
  </div>
<?php
endif;
?>


<input type="hidden" name="IDNRO" value="<?= $OPERACION != "A" ?  $deudor_dato->IDNRO : "" ?>">

 
<?= $this->include("deudor/forms/personales") ?>
<?= $this->include("deudor/forms/laborales") ?>
<?= $this->include("deudor/forms/posesiones") ?>
<?= $this->include("deudor/forms/otros") ?>

<?php if (isset($OPERACION) && $OPERACION != "V") : ?>

  <div class="form-group mt-3">
    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
      <button type="submit" class="btn btn-success">GUARDAR</button>
    </div>
  </div>
<?php endif; ?>


<script>
  //mostrar imagen seleccionada
  function show_loaded_image(ev) {
    let entrada = ev.srcElement;
    console.log(entrada);
    let reader = new FileReader();
    reader.onload = function(e) {
      var filePreview = document.createElement('img');
      filePreview.className = "img-thumbnail";
      filePreview.src = e.target.result;
      filePreview.style.width = "100%";
      filePreview.style.maxHeight = "100%";
      let tagDestination = "#" + ev.target.name;
      var previewZone = document.querySelector(tagDestination);
      previewZone.innerHTML = "";
      previewZone.appendChild(filePreview);
    };
    reader.readAsDataURL(entrada.files[0]);
  } // show_loaded_image( event, "#idid")







  function mostrar_ficha(ev) {
    if (ev.keyCode == 13) {
      let cedula = $("#CEDULA").val();
      $.ajax({
        url: "<?= base_url("deudor/view") ?>/" + cedula,
        beforeSend: function() {},
        success: function(resp) {
          $("#form-1").html(resp);
        },
        error: function() {
          new PNotify({
            title: 'ERROR',
            text: '',
            type: 'error',
            styling: 'bootstrap3'
          });
        }
      });
    }
  }



  window.onload = function() {
    autocompletado();
    //FECHAS
    $("input[type=date]").each(function(index, elemento) {
      if (this.value == "")
        $(elemento).css("color", "white");
      $(elemento).bind("change", function() {
        if (this.value == "" || this.value == undefined) {
          console.log(this.value);
          $(this).css("color", "white");
          return;
        }
        $(this).css("color", "black");
      })
    }); /** end fechas */
  }
</script>