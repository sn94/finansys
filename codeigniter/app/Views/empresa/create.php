 <!-- INI FORM -->

 <?php

    $ruta =  isset($dato) ? "empresa/edit" : "empresa/create";

    echo form_open(
        $ruta,
        [
            "style" => "padding-left: 5px;",
            "class" => "form-horizontal form-label-left container prestyle", "onsubmit" => "guardarEmpresa(event)"
        ]
    );
    ?>

 <?php echo view('empresa/form'); ?>

 </form>


 <script>
     async function guardarEmpresa(e) {
         e.preventDefault();
         let req = await fetch(e.target.action, {
             method: "POST",
             headers: {
                 'Content-Type': "application/x-www-form-urlencoded"
             },
             body: $(e.target).serialize()

         });

         let resp = await req.json();

        Array.prototype.forEach.call(  e.target.elements, function(tag){

            tag.value="";
        });
         if ("ok" in resp) fill_grill();
         else alert(resp.error);
     }
 </script>