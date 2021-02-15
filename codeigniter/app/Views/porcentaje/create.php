 <!-- INI FORM -->

 <?php
    echo form_open_multipart(
        "porcentaje/create",
        [
            "style" => "padding-left: 5px;",
            "class" => "form-horizontal form-label-left container prestyle",
            "onsubmit"=>"guardar(event)"
        ]
    );
    ?>




 <?php echo view('porcentaje/form'); ?>

 </form>

 <script>
     async function guardar(ev) {
         ev.preventDefault();
         let req = await fetch(ev.target.action, {
             "method": "POST",
             headers: {
                 'Content-Type': 'application/x-www-form-urlencoded'
             },
             body: $(ev.target).serialize()
         });
         let resp = await req.json();
         if ("ok" in resp)
             act_grilla();
         else alert(resp.error);

     }
 </script>