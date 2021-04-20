<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
Usuarios
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<style>
table thead tr th, table tbody tr td, table tfoot td{
  padding: 0px !important;
}
</style>

<a href="<?= base_url("usuario/create") ?>" class="btn btn-sm btn-primary">NUEVO</a>
<div class="table-responsive">

  <!-- ********************TABLA ***************** -->
  <table id="tabla-funcionarios" class="table table-bordered table-striped table-primary table-hover">
    <thead class="dark-head">
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th> NICK </th>
        <th>NIVEL</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($lista as $i) : ?>
        <tr id="<?= $i->IDNRO ?>">
          <td><a href="<?= base_url("usuario/view/$i->IDNRO") ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
          <td><a href="<?= base_url("usuario/edit/$i->IDNRO") ?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
          <td><a onclick="borrarFila(event)" href="<?= base_url("usuario/delete/$i->IDNRO") ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          <td><?= $i->NICK ?></td>
          <td><?= $i->ROL == "A" ? "ADMINISTRADOR" : ($i->ROL == "S" ? "SUPERVISOR" : "COBRADOR")  ?></td>
        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>
</div>


<script>
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