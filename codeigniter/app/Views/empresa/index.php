<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
Empresas
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<div class="card">


  <div class="card-body">



    <!--form -->
    <div id="formView">
      <?php echo view("empresa/create"); ?>
    </div>
    <!--End form-->

    <div class="table-responsive">

      <!-- ******************* CAJA  ***************** -->
      <table id="tabla-auxi" class="table table-bordered table-stripped">
        <thead class="dark-head">
          <tr style="font-family: mainfont;">
            <th></th>
            <th></th>
            <th>DESCRIPCIÓN</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($lista as $i) : ?>

            <tr id="<?= $i->IDNRO ?>">
              <td><a onclick="editarFila(event)" href="<?= base_url("empresa/edit/" . $i->IDNRO) ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
              <td><a onclick="borrarFila(event)" href="<?= base_url("empresa/delete/" . $i->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
              <td> <?= $i->DESCR != "" ? $i->DESCR : "****"  ?> </td>
            </tr>

          <?php endforeach; ?>

        </tbody>
      </table>
    </div>
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
</script>
<?= $this->endSection() ?>