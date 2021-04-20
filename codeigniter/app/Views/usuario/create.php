<?= $this->extend("layouts/index") ?>

<?= $this->section("title") ?>
Ficha de usuario
<?= $this->endSection() ?>

<?= $this->section("contenido") ?>


<a class="btn btn-sm btn-primary" href="<?= base_url("usuario/index")?>">
<i class="fa fa-user" aria-hidden="true"></i> &nbsp; LISTADO DE USUARIOS</a>
 


<!-- INI FORM -->
<?php 
echo form_open("usuario/create", 
['id'=> "edit-usuario-form", "style"=>"padding-left: 10px;",
 "class"=> "form-horizontal   container prestyle", "onsubmit"=> "enviarUsuario(event)" ])
?>
<?php echo view('usuario/forms/index'); ?>

</form>
 
 
<script>

    function enviarUsuario( ev){
        ev.preventDefault();
        let tipoUsuario= document.getElementById("ROL").value;
        let permisos= document.getElementById("permisos");
        if(  tipoUsuario=="U" ){
            if( permisos != null){
                let filas= permisos.children;
                let chequeados= Array.prototype.filter.call( filas, function(item){
                    let columnas= item.children;
                    return columnas[1].firstChild.checked;
                });
                if( chequeados.length > 0) {

                    //verificar pertinencia de permisos
                    ev.target.submit();
                }
                else{  alert("INDIQUE PERMISOS");  return; }
            }else  ev.target.submit();

        }else
        ev.target.submit();
    }

</script>

<?= $this->endSection() ?>


