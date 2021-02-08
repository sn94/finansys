<?= $this->extend("layouts/index") ?>

<?= $this->section("contenido") ?>


<a  style="font-weight: 600;"  href="<?= base_url("prestamo/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; CRÉDITOS</a>


<div class="container p-2">
<h2 class="text-center prestyle">SOLICITUD DE PRÉSTAMO<small></small></h2>
<div class="clearfix"></div>
</div>


<!-- INI FORM -->
 
<?php echo view('prestamo/best_view'); ?>
 


<script>

/*
function guardar(ev, show_content){
    ev.preventDefault();
    let ENCTYPE= 'application/x-www-form-urlencoded';
    if( ev.target.enctype ==  "multipart/form-data")  ENCTYPE=  "multipart/form-data";

    let DATA= ( ev.target.enctype ==  "multipart/form-data")? new FormData(  ev.target ): $(ev.target).serialize(); 

    let SETTING= {
        url:  ev.target.action,
        enctype: ENCTYPE,
        data: DATA,
        method: "POST",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        beforeSend: function(){  $(show_content).html("Espere.."); },
        success: function(res){ new PNotify({
                                  title: 'GUARDADO',
                                  text: '',
                                  type: 'success',
                                  styling: 'bootstrap3'
                              });    },
        error: function(res){   $(show_content).html("Error");  }
    };
    if ( ev.target.enctype ==  "multipart/form-data"){
        SETTING.processData= false; SETTING.contentType= false;
    }
    $.ajax(  SETTING)
  }*/

    
  
</script>

<?= $this->endSection() ?>


