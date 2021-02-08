<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>

 

<div class="card">
                <div class="card-header card-header-primary"> 
                  <h2 class="text-center prestyle"> Copias de seguridad<small></small></h2>  
                </div>



<div class="card-body">

<p >BACKUP *Copia de Seguridad*</p>
<a  onclick="DoBackup(event)" href="<?= base_url("backup/db_action/backup") ?>" class="btn btn-sm btn-primary">GENERAR BACKUP</a>
  

</div><!-- END CARD BODY  -->



<div class="table-responsive">

<!-- ******************* CAJA  ***************** -->
<table class="table table-bordered table-stripped prestyle">
  <thead class="dark-head">
  <tr><th>Nombre archivo</th> <th></th><th></th>  <th></th></tr>
  </thead>
<tbody>
                       
<?php

$idrow= 1;
foreach($lista as $i):?>

<tr>
<td><?=$i['archivo']?></td>  <td> <a href="<?=$i['href']?>">Descargar</a></td>
<td><a  target="<?=$idrow?>"  href="<?= base_url("backup/db_action/restore") ?>"  onclick="restaurar(event)">Restaurar</a>
<input type="hidden"  id="<?=$idrow?>"  value="<?=$i['archivo']?>">
</td>
<td>
  <a target="<?=$idrow?>"  onclick="borrar(event)" href="<?= base_url("backup/borrar") ?>"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
</td>
</tr>
<?php 

endforeach;?>
                   
</tbody>
</table>
</div>


</div>


<script>

  
 function generarBackup( ev ){
    ev.preventDefault();


    get_custom( ev.currentTarget.href, function( res){

      let resp= JSON.parse(  res );


    });
 }





 function borrar(  ev ){
  ev.preventDefault();
  let obje=ev.currentTarget;
  let fileName=  document.getElementById(   ev.currentTarget.target ).value;
  let SETTING= {
        url:   obje.href,
        data: JSON.stringify( { linkfile:   fileName }),
        method: "POST",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        beforeSend: function(){ 
            $("#spinner_system").css("display", "block")
       
        },
        success: function(res){  
          
          $("#spinner_system").css("display", "none"); 
          new PNotify({
                                  title: 'BORRADO',
                                  text: '',
                                  type: 'success',
                                  styling: 'bootstrap3'
                              }); 

        },
        error: function(res){
            $("#spinner_system").css("display", "none") 
            new PNotify({
                                  title: 'ERROR',
                                  text: '',
                                  type: 'danger',
                                  styling: 'bootstrap3'
                              });  
         }
    };
     
    $.ajax(  SETTING)
}
 




function restaurar(  ev ){
  ev.preventDefault();
  let obje=ev.currentTarget;
  let fileName=  document.getElementById(   ev.currentTarget.target );
  let SETTING= {
        url:   obje.href,
        data: JSON.stringify( { backup_name:   fileName }),
        method: "POST",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        beforeSend: function(){ 
            $("#spinner_system").css("display", "block")
       
        },
        success: function(res){  $("#spinner_system").css("display", "none"); success(res);},
        error: function(res){
            $("#spinner_system").css("display", "none") 
            new PNotify({
                                  title: 'ERROR',
                                  text: '',
                                  type: 'danger',
                                  styling: 'bootstrap3'
                              });  
         }
    };
     
    $.ajax(  SETTING)
}
 
</script>
<?= $this->endSection() ?>


