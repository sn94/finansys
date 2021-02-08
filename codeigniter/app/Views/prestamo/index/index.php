<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>

 
 
<div class="card">
                <div class="card-header card-header-primary">
                <h2 class="text-center prestyle"><?= isset($titulo) ?  $titulo : "PRÉSTAMOS" ?><small></small></h2>  
            

                <?php  if( !isset($titulo) ):  ?>
                 <a href="<?= base_url("prestamo/create") ?>" class="btn btn-sm btn-primary">NUEVO</a>
                <?php  endif; ?>

                </div>
<div class="card-body">
         
<div class="table-responsive">

<?php  if( !isset($titulo) ):  
echo view("prestamo/index/grilla");
else: 
  echo view("prestamo/index/grilla_cobros");
endif; ?>

</div>
<!-- END TABLA --> 

</div>
</div>


<script>


function rechazarSolicitud(ev){

ev.preventDefault();
if(  ! confirm("Seguro que desea rechazar esta solicitud?")) return;
$.ajax( { url: ev.currentTarget.href,dataType: "json", success: function(resp){
 
    new PNotify({
                                  title: '',
                                  text: resp.MENSAJE,
                                  type: 'danger',
                                  styling: 'bootstrap3'
                              });  

  window.location= "<?=base_url("prestamo/index")?>";
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

  window.onload= function(){
 
    $("#tabla-funcionarios").DataTable(   {   
          "ordering": false,
          "language": {
            "url": "<?=base_url("assets/Spanish.json")?>"
          }
        }  );
  }


 
</script>
<?= $this->endSection() ?>