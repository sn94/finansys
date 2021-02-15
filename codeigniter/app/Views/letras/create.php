 <!-- INI FORM -->

 <?php
    echo form_open_multipart(
        "letras/create",
        [
            "style" => "padding-left: 5px;",
            "class" => "form-horizontal form-label-left container prestyle",
            "onsubmit" => "guardar(event)"
        ]
    );
    ?>




 <?php echo view('letras/form'); ?>

 </form>