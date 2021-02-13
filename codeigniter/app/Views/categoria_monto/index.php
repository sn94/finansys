<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>


<div class="card">
  <div class="card-header card-header-primary">
    <h2 class="text-center prestyle">TIPOS DE MONTO<small></small></h2>

  </div>

  <div class="card-body">



    <!--form -->
    <div id="formView">
      <?php

      echo view("categoria_monto/create"); ?>
    </div>
    <!--End form-->

    <div class="table-responsive" id="GRILL">

      <?php
      echo view("categoria_monto/grill");
      ?>

    </div>
    <!--End table responsive -->

  </div>


</div>


<script>
  function editarFila(ev) {
    ev.preventDefault();
    $.ajax({
      url: ev.currentTarget.href,
      success: function(resp) {
        $("#formView").html(resp);
      }
    });
  }


  function borrarFila(ev) {

    ev.preventDefault();
    if (!confirm("BORRAR?")) return;
    $.ajax({
      url: ev.currentTarget.href,
      dataType: "json",
      success: function(resp) {
        console.log(typeof resp, resp);
        if (!("error" in resp)) //Ojo los parentesis internos
          $("#" + resp.id).remove();
      }
    });

  }




  async function act_grilla() {
    let endpoint = "<?= base_url('categoria-monto/index') ?>";
    show_loader();
    let req = await fetch(endpoint, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    });
    let resp = await req.text();
    hide_loader();
    $("#GRILL").html(resp);

  }

</script>
<?= $this->endSection() ?>