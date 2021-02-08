<div class="container p-2">
<?php echo form_open("prestamo/cobro", ['id'=> "cobro-form",  "class"=>"form-inline", 'onsubmit'=>'guardar(event, prepararFormCobro)' ]);?>
                  <div class="form-group">
                    <label for="ex3">Nombre o Cédula:</label>
                    <input type="text" id="ex3"  name="busqueda" class="form-control" placeholder=" ">
                  </div>
                  <button type="submit" class="btn btn-default">Buscar</button>
</form>

<div class="clearfix"></div>
</div>
<table class="table table-bordered table-stripped">
<thead><th>CÉDULA</th><th>NOMBRES</th></thead>
<tbody>

</tbody>
</table>
<script>

function prepararFormCobro(res ){
        $("#vista-form-cobro").html( res );
    }

</script>
 