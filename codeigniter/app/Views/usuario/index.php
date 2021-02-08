<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>


<div class="card">
                <div class="card-header card-header-primary">
                <h2 class="text-center prestyle">USUARIOS<small></small></h2>  
                 <a href="<?= base_url("usuario/create") ?>" class="btn btn-sm btn-primary">NUEVO</a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">

<!-- ********************TABLA ***************** -->
<table id="tabla-funcionarios" class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
  <tr><th></th><th></th><th></th><th> NICK </th><th>NIVEL</th> </tr>
  </thead>
<tbody>
                       
<?php  foreach($lista as $i):?>
<tr id="<?=$i->IDNRO?>">
<td><a href="<?= base_url("usuario/view/$i->IDNRO")?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
<td><a href="<?= base_url("usuario/edit/$i->IDNRO")?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
<td><a onclick="borrarFila(event)" href="<?= base_url("usuario/delete/$i->IDNRO")?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
 <td><?=$i->NICK?></td> <td><?=$i->ROL == "A" ? "ADMINISTRADOR" : ( $i->ROL == "S" ? "SUPERVISOR" : "COBRADOR")  ?></td> </tr>
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