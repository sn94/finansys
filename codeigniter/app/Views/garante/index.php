<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>


<div class="card">
                <div class="card-header card-header-primary"> 
                  <h2 class="text-center prestyle"> GARANTES<small></small></h2>  

                 <a href="<?= base_url("garante/create") ?>" class="btn btn-sm btn-primary">NUEVO</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">

<!-- ********************TABLA ***************** -->
<table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
  <tr><th></th><th></th><th></th><th>CI°</th><th>NOMBRES</th><th>APELLIDOS</th><th>CIUDAD</th><th>TELÉFONO</th></tr>
  </thead>
<tbody>
                       
<?php  foreach($lista as $i):?>
<tr id="<?=$i->IDNRO?>">
<td><a href="<?= base_url("garante/view/$i->IDNRO")?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
<td><a href="<?= base_url("garante/edit/$i->IDNRO")?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
<td><a onclick="borrarFila(event)" href="<?= base_url("garante/delete/$i->IDNRO")?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
<td><?=$i->CEDULA?></td><td><?=$i->NOMBRES?></td><td><?=$i->APELLIDOS?></td><td><?=$i->CIUDAD?></td><td><?=$i->TELEFONO?></td></tr>
                        <?php  endforeach;?>
                   
</tbody>
</table>
</div>
</div>
</div>


<script>


function borrarFila( ev){

ev.preventDefault();
if( !confirm("BORRAR?")) return;
$.ajax( { url: ev.currentTarget.href,dataType: "json", success: function(resp){
  console.log( typeof resp, resp );
    if( ! ("error" in resp) ) //Ojo los parentesis internos
    $("#"+resp.id).remove();
}});
 
}

  window.onload= function(){
    $("#tabla-funcionarios").DataTable(    {   
            "ordering": false,
            "language": {
              "url": "<?=base_url("assets/Spanish.json")?>"
            }
          });
  }


 
</script>
<?= $this->endSection() ?>