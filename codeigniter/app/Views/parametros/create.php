 <!-- INI FORM -->

 <?php
    echo form_open_multipart(
        "parametros/create",
        [
            "id"=> "param-form",
            "style" => "padding-left: 5px;",
            "class" => "form-horizontal form-label-left container prestyle",
            "onsubmit" => "guardar(event)"
        ]
    );
    ?>




 <?php echo view('parametros/form'); ?>

 </form>

