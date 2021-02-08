<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>


<div class="card">
<div class="card-header card-header-primary">
<h2 class="text-center prestyle">CAJAS<small></small></h2>   
                  
</div>

<div class="card-body">
 
 

<!--form --> 
<div id="formView">
<?php  echo view("caja/create"); ?>
</div>
<!--End form--> 

<div class="table-responsive">

<!-- ******************* CAJA  ***************** -->
<table id="tabla-auxi" class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
  <tr><th></th> <th></th><th></th> <th>ESTADO</th></tr>
  </thead>
<tbody>
                       
<?php  foreach($lista as $i):?>

<tr id="<?=$i->IDNRO?>">  
<td><a onclick="editarFila(event)" href="<?= base_url("caja/edit/".$i->IDNRO)?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
<td><a onclick="borrarFila(event)" href="<?= base_url("caja/delete/".$i->IDNRO)?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
<td> <?= $i->NOMBRE?></td>
<td> <?= $i->ESTADO == "H" ? "HABILITADA" : "DESHABILITADA"  ?> </td>  </tr>

<?php  endforeach;?>
                   
</tbody>
</table>
</div>
</div>
</div>


<script>


function editarFila(ev){
  ev.preventDefault();
$.ajax( { url: ev.currentTarget.href,  success: function(resp){
 $("#formView").html( resp);
}});
}

 
function borrarFila( ev){

ev.preventDefault();
if( !confirm("BORRAR?")) return;
$.ajax( { url: ev.currentTarget.href,dataType: "json", success: function(resp){
  console.log( typeof resp, resp );
    if( ! ("error" in resp) ) //Ojo los parentesis internos
    $("#"+resp.id).remove();
}});
 
}

   
</script>
<?= $this->endSection() ?>