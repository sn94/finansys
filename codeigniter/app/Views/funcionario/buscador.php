<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
        <style>
            .texto{
                border: 1pt #a29bf7 solid;
                font-size: 16px;
                font-weight: 600;
                color: #363636;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                width: 100%;
            }

            .grilla thead tr{
                background-color: #8e8eea;
                font-size: 12px;
            }
            .grilla{
              
                width: 100%;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                cursor:pointer; cursor: hand
            }
            .grilla tbody tr{
                border-bottom: 1pt #7edaed solid;
                background-color: #bbbcf2;
            }
            .grilla tbody tr:hover{
                background-color: #57eaea;
            }
            .grilla tbody tr td{
                padding-left: 2px;
                padding-right: 2px;
            }
        </style>
    </head>
    <body>
      
    <input autofocus class="texto" oninput="actualizarBuscador()" type="text" placeholder="Ingrese algun nombre, o cedula " id="buscado">
      <table class="grilla">
      <thead>
      <tr><th>CI°</th><th>NOMBRE COMPLETO</th></tr>

      <tbody id="buscador_">

      <?php  foreach($lista as $item):?>

        <tr id="<?=$item->IDNRO?>" ><td>   <?=$item->CEDULA?>   </td>  <td><?=$item->NOMBRES?></td></tr>

      <?php  endforeach; ?>


    
      </tbody>
      </thead>
      </table>

      <script>

        var IDClient= "";

            function elegir( ev){
                IDClient= ev.currentTarget.id;
                close();
            }


            function actualizarGrilla( lista){

                let tabla=  document.getElementById("buscador_");
                //vaciar
                tabla.innerHTML= "";
                lista.forEach(function(item){
                    let nuevafila= "<tr onclick='elegir(event)' id='"+item.IDNRO+"'><td>"+item.CEDULA+"</td><td>"+item.NOMBRES+"</td></tr>";
                    tabla.innerHTML= tabla.innerHTML + nuevafila ;
                });
            }
          function actualizarBuscador(){


            let url= "<?=base_url("funcionario/buscar_por_palabra")?>";
            let termino_buscado= document.getElementById("buscado").value;
            fetch(  url, 
            {method: "POST",
            headers: {  "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"},
            body: JSON.stringify(  { buscado: termino_buscado })  })
            .then(function(res){
                return res.json();
            }).then(function(listjson){

                actualizarGrilla( listjson) ;


            });
          }



      </script>
    </body>
</html>