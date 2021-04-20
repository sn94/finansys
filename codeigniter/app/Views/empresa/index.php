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

    <div class="table-responsive" id="grill">
 
      <?=view("empresa/grill")?>
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


  async function fill_grill() {
    let req = await fetch("<?= base_url("empresa/index") ?>", {
      headers:{'X-Requested-With': 'XMLHttpRequest'}
    });

    let resp = await req.text();
    $("#grill").html(resp);
  }
</script>
<?= $this->endSection() ?>