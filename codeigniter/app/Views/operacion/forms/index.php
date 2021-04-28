<style>
    input[readonly] {
        background-color: #8a96d7  !important;
        color: black !important;
    }
</style>





<input type="hidden" name="FUNCIONARIO" value="<?= session("ID") ?>">


<div class="row mr-md-5 ml-md-5 mb-0 pt-0 bg-primary text-light rounded"  >

    

    <div class="col-12 col-md-6 pt-1">
        <?= view("operacion/forms/form_data_principal") ?>
    </div>

    <div class="col-12 col-md-6 pt-1 bg-primary rounded mt-2" id="FICHA-CLIENTE">

        <?= view("operacion/forms/form_cliente_view") ?>
    </div>



</div>

<div class="row mr-md-5 ml-md-5 mb-1 pt-2 mt-2 mt-0 bg-primary rounded">

<div class="col-12 col-md-4 bg-primary  pt-1">
        <?= view("operacion/forms/form_seguro_gasto") ?>
    </div>


    <div class="col-12 col-md-4 ">
        <?= view("operacion/forms/form_intereses") ?>
    </div>

    <div class="col-12 col-md-4">
        <?= view("operacion/forms/form_montos_calculados") ?>
    </div>

    <div class="col-12 col-md-2  ">
        <div class="row mr-md-5 ml-md-5 ">
            <div class="col-12">
                <button id="BOTON-ENVIO" type="submit" class="btn btn-success"> GUARDAR</button>
            </div>
        </div>
    </div>
   
</div>







 
<?= view("operacion/js/boot") ?> 