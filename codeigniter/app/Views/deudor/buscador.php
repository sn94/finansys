 <!-- BUSCADOR DE CLIENTES  -->
 <!--URL DE LISTADO DE CLIENTES-->
 <input type="hidden" id="CLIENTE-INDEX" value="<?= base_url("deudor/index/index") ?>">
 <!--campo de busqueda -->
 <input type="text" oninput="filtrar_clientes(event)" id="BUSCADO" placeholder="BUSCAR POR CEDULA, O NOMBRE" class="form-control mt-2">
 <div class="table-responsive" id="GRILL">
     <?= view("deudor/index/grill/index") ?>
 </div>


 <script>
     async function act_grilla(ev) {
 
         show_loader();

         let req = await fetch( ev.currentTarget.href_, { 
             headers: { 
                 'X-Requested-With': 'XMLHttpRequest'
             }
         });
         let html_result = await req.text();

         $("#GRILL").html(html_result);

     }

     async function filtrar_clientes(ev) {

         let buscado = ev == undefined ? "" : ev.target.value;
         let url_ = $("#CLIENTE-INDEX").val();
 
         show_loader();

         let req = await fetch(url_, {
             "method": "POST",
             headers: {
                 'Content-Type': 'application/x-www-form-urlencoded',
                 'X-Requested-With': 'XMLHttpRequest'
             },
             body: "BUSCADO=" + buscado
         });
         let html_result = await req.text();

         $("#GRILL").html(html_result);

     }
 </script>