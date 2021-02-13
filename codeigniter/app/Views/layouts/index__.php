<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>PRESTASYS </title>


    <!-- Custom Theme Style -->
    <link href="<?= base_url("assets/merged.css")?>" rel="stylesheet">
    <link href="<?= base_url("assets/pnotify.css")?>" rel="stylesheet">
    <link href="<?= base_url("assets/pnotify.buttons.css")?>" rel="stylesheet">
    <link href="<?= base_url("assets/table-export/tableexport.min.css")?>" rel="stylesheet">
   <!--Any chart --> 

   <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">

        <!--Any Chart --> 
     
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/themes/dark_blue.min.js"></script>
    <style>
        
        .centerme{
            display: inline-block;
            vertical-align: middle;
            float: none;
        }
        h2.prestyle{
            color: #2e2e2e;
            font-weight: 600;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        h4.prestyle{
            color: #4b4b4b; font-weight: bold;
        }
        form.prestyle label,  form.prestyle input[type=text], .prestyle tr,a,label.prestyle, input[type=text].prestyle{
            font-size: 10pt;
            color: #2a2a2a;
            font-weight: 600;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }  
        p{    font-family: Verdana, Geneva, Tahoma, sans-serif; }
       form.prestyle select, select.prestyle{
            font-size: 10pt;
            font-family: Verdana, Geneva, Tahoma, sans-serif ;
            font-weight: 600 !important;
        }
        form.prestyle input[type=text], input[type=text].prestyle,  form.prestyle select, select.prestyle{
            color: #444444;
        }
        .prestyle thead tr{ color: white;background-color: #2a3f54 !important;  }
        .prestyle tbody tr{    background-color: #b4b9fe;   }


    .table-primary{
    background-color: #7ca9fc !important;
  }    
  .table-success{
    background-color: #95f88f !important;
  }
  .table-danger{
    background-color: #fd9586 !important;
  }
  .table-secondary{
    background-color: #cecece !important;
  }

  .icon-success{
    color: #0f8c09 !important;
  }
  .icon-danger{
    color: #fa2405 !important;
  }
  


  fieldset{
    border: 1px solid #9999ca; border-radius: 20px;padding-bottom: 5px;
    margin-bottom: 2px;
    width: 100%;
    height: 100%;
  }
  fieldset legend{
    padding-left: 5px;
     padding-top: 2px; 
     border-radius: 12px 12px 0px 0px;
     background-color: #8eb9b5; 
     color:white; 
    text-shadow: 1px 1px 8px #04043c; 
    font-size: 11pt;
     font-weight: 600;
  }
  fieldset label.sobrio{
    text-transform: capitalize;
    font-size: 9pt;
    font-weight: 600;
    color:#4d4d4d;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
  }
    </style>

</head>

<body class="nav-md">

<img   id='spinner_system'   style='display:none;left: 50%;right: 50%; position: absolute; z-index: 180000000;' src='<?=base_url("assets/img/spinner.gif") ?>'' >
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?=base_url()?>" class="site_title"><i class="fa fa-money fa-lg"></i> <span></span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?=base_url("assets/images/img.jpg")?>" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bienvenido/a,</span>
                            <h2><?= session("NICK")?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-home"></i> Cr&eacute;ditos <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url("deudor/index")?>">Datos de cliente</a></li>
                                        <li><a href="<?=base_url("garante/index")?>">Garantes</a></li>
                                        <li><a href="<?=base_url("prestamo/index")?>">Préstamos</a></li>  
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-edit"></i> Caja <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu"> 
                                        <li><a     href="<?=base_url("apeciecaja/apertura")?>">Apertura de caja</a></li>  
                                        
                                        <li><a  href="<?=base_url("apeciecaja/arqueo_cierre")?>">Cierre de caja</a></li>
                                        <li><a   href="<?=base_url("prestamo/cobros")?>">Cobros</a></li>    
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-desktop"></i> Auxiliares <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url("funcionario/index")?>">Funcionarios</a></li>
                                        <li><a href="<?=base_url("caja/index")?>">Caja</a></li>
                                        <li><a href="<?=base_url("cargo/index")?>">Cargos de funcionario</a></li>
                                        <li><a href="<?=base_url("categoria_monto/index")?>">Categoría de monto</a></li>
                                        <li><a href="<?=base_url("usuario/index")?>">Usuarios</a></li> 
                                    </ul>
                                </li>
                               
                                <li><a><i class="fa fa-bar-chart-o"></i> Informes <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="<?=base_url("prestamo/informes_cobros")?>">Cobros Realizados</a></li>
                                        <li><a href="<?=base_url("prestamo/informes_cuotas")?>">Filtrar Cuotas</a></li>
                                        <li><a href="<?=base_url("prestamo/informes_capital_interes")?>">Capital & inter&eacute;s</a></li>
                                        <li><a href="<?=base_url("prestamo/informes_conducta_pago")?>">Conducta de pago</a></li>
                                        <li><a href="tables.html">Saldos a cobrar</a></li>
                                        <li><a href="tables_dynamic.html">Cuotas vencidas</a></li>
                                          
                                    </ul>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>SOPORTE TÉCNICO</h3>
                            <ul class="nav side-menu">
                              
                                 
                                    <li><a href="<?=base_url("backup")?>"><i class="fa fa-laptop"></i> Copias de seguridad <span class="label label-success pull-right">Nuevo</span></a></li>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?= base_url("assets/images/img.jpg")?>" alt=""><?=session("NICK")?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li><a href="javascript:;"> Profile</a></li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="badge bg-red pull-right">50%</span>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                    <li><a href="javascript:;">Help</a></li>
                                    <li><a href="<?=base_url("usuario/sign_out")?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                </ul>
                            </li>

                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image"><img src="<?= base_url("assets/images/img.jpg")?>" alt="Profile Image" /></span>
                                            <span>
                          <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img src="<?= base_url("assets/images/img.jpg")?>" alt="Profile Image" /></span>
                                            <span>
                          <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img  src="<?= base_url("assets/images/img.jpg")?>"  alt="Profile Image" /></span>
                                            <span>
                          <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image"><img  src="<?= base_url("assets/images/img.jpg")?>" alt="Profile Image" /></span>
                                            <span>
                          <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main" style="min-height: 3627px;">
          <div class="">
            
            <div class="clearfix"></div>

            
            <div class="row">
              

              <div class="col-12"><!-- col-md-12 col-xs-12 -->
                
                  
                  
            <?= $this->renderSection("contenido") ?>

                 
            
              </div>

 
            </div>

          

            

 
          </div>
        </div>


            
         
           
            <!-- /page content -->


            <!-- MODAL --> 
            <div style="z-index: 400000;" id="formmodal" class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content" >

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2"></h4>
                        </div>
                        <div class="modal-body" id="apecie-content">
                       
                        </div>
                         

                      </div>
                    </div>
                  </div>
            <!-- end MODAL --> 



            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    PRESTASYS v.2020<a href="https://colorlib.com">Colorlib</a>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>


    <!-- Custom Theme Scripts -->
    <script src="<?=base_url("assets/merged.js")?>"></script>

    <!--AUTOCOMPLETADO --> 
    <script src="<?=base_url("assets/jquery.autocomplete.min.js")?>"></script>
    <script src="<?=base_url("assets/jquery.dataTables.min.js")?>"></script>
    <!--Wizard--> 
    <script src="<?=base_url("assets/jquery.smartWizard.js")?>"></script>
    <!--Notificacion-->
    <script src="<?=base_url("assets/pnotify.js")?>"></script>
    <script src="<?=base_url("assets/pnotify.buttons.js")?>"></script>
    <!--XLS GEN --> 
   
    <script src="<?=base_url("assets/xls_gen/xls.js")?>"></script> 
    <script src="<?=base_url("assets/xls_gen/xls_ini.js")?>"></script>




  
   
    
    <script>


//graficos


MostrarEstadisticaCobro();

async function MostrarEstadisticaCobro(){ 
    let resultados= await  fetch("<?=base_url("prestamo/total_cobrados_por_dia")?>");
    let resultados_=   await resultados.json();
    //preparar info
    let sourceData= resultados_.map(function(item){
        return [item.FECHA, parseInt(item.EFECTIVO), parseInt( item.CHEQUE), parseInt(item.TARJETA) ];
    });
    graficar(  sourceData);
}
 


//anychart.onDocumentReady(
    var graficar= function (dataSet_) {
	// set chart theme
anychart.theme('darkBlue');
      // create data set on our data
   /*  var dataSet = anychart.data.set([
        ['Nail polish', 12814, 3054, 4376],
        ['Eyebrow pencil', 13012, 5067, 3987],
        ['Rouge', 11624, 7004, 3574, 5221],
        ['Lipstick', 8814, 9054, 4376, 9256],
        ['Eyeshadows', 12998, 12043, 4572, 3308],
        ['Eyeliner', 12321, 15067, 3417, 5432],
        ['Foundation', 10342, 10119, 5231],
        ['Lip gloss', 22998, 12043, 4572],
        ['Mascara', 11261, 10419, 6134]
      ]);*/
     
        var dataSet=  anychart.data.set(  dataSet_) ;
     
      // map data for the first series, take x from the zero column and value from the first column of data set
      var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });

      // map data for the second series, take x from the zero column and value from the second column of data set
      var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });

      // map data for the second series, take x from the zero column and value from the third column of data set
      var thirdSeriesData = dataSet.mapAs({ x: 0, value: 3 });
 
      // create bar chart
      var chart = anychart.bar();

      // turn on chart animation
      chart.animation(true);

      // force chart to stack values by Y scale.
      chart.yScale().stackMode('percent');

      // set chart title text settings
      chart.title('TOTAL COBRADOS POR DIA Y POR MODALIDAD');

      // set yAxis labels formatting, force it to add % to values
      chart.yAxis(0).labels().format('{%Value}%');

      // helper function to setup label settings for all series
      var setupSeriesLabels = function (series, name) {
        series.name(name).stroke('3 #fff 1');
        series.hovered().stroke('3 #fff 1');
      };

      // temp variable to store series instance
      var series;

      // create first series with mapped data
      series = chart.bar(firstSeriesData);
      setupSeriesLabels(series, 'EFECTIVO');

      // create second series with mapped data
      series = chart.bar(secondSeriesData);
      setupSeriesLabels(series, 'CHEQUE');

      // create third series with mapped data
      series = chart.bar(thirdSeriesData);
      setupSeriesLabels(series, 'TARJETA');

  

      // turn on legend
      chart.legend().enabled(true).fontSize(14).padding([0, 0, 15, 0]);

      chart.interactivity().hoverMode('by-x');

      chart.tooltip().displayMode('union').valuePrefix('$');

      // set container id for the chart
      chart.container('rating-cobros');
      // initiate chart drawing
      chart.draw();
    };
   // );

  /** End graficos  */             






function hoy(){
    let fechaBase= new Date();
    let anio=   fechaBase.getFullYear(); 
      let mes= (fechaBase.getMonth()+1) < 10 ? "0"+(fechaBase.getMonth()+1) : (fechaBase.getMonth()+1);
      let diaa= (fechaBase.getDate()) < 10 ? "0"+(fechaBase.getDate()) : (fechaBase.getDate());
      let FECHA=  anio+"-"+ mes+"-"+ diaa;
      return FECHA;
  }



//DESHABILITAR HABILITAR CAMPOS DE FORM
function habilitarCampos( targetId, hab){
   
    let target= document.getElementById(targetId);
    let context= target.elements;
    Array.prototype.forEach.call( context, function(ar){ar.disabled=!hab;   });
  }



//Autocomplete
function autocompletado(){
    $.ajax( {
    url: "<?=base_url("assets/ciudades.json")?>",
    dataType: "json",
    success:function( res){
        var dataArray = res.map(function(value) {
        return {
            value: value.nombre,
            data: value.id_ciu
        };
        });
        // initialize autocomplete with custom appendTo
       /* $(id).autocomplete({
        lookup: dataArray
        });*/
        /**test */
        let elementosCoincidentes= document.querySelectorAll(".ciudad");
        console.log( elementosCoincidentes);
        Array.prototype.forEach.call(  elementosCoincidentes,  function(entrada){
            $(entrada).autocomplete({ lookup: dataArray    });
        });
        /**end test */
    }//End Success
});
}




/***Autocomplete end  */


 //mostrar imagen seleccionada
 function show_loaded_image(  ev){
        let entrada=  ev.srcElement;
        console.log( entrada);
        let reader = new FileReader();
        reader.onload=    function(e){
        var filePreview = document.createElement('img');
        filePreview.className= "img-thumbnail";
        filePreview.src = e.target.result;
        filePreview.style.width =  "100%";
        filePreview.style.maxHeight="100%";
        let tagDestination= "#"+ev.target.name;
        var previewZone = document.querySelector( tagDestination);
        previewZone.innerHTML="";
        previewZone.appendChild(filePreview); 
        };
        reader.readAsDataURL(   entrada.files[0]);
}// show_loaded_image( event, "#idid")



//Limpia campos numericos del separador de miles
function quitarSeparador( obj){ 
    
let w= "";
if( typeof obj == "object") {w=   obj.value.replaceAll(/\./g , ""); obj.value= w;}
else{   w= (obj=="") ? 0 :    (obj.replaceAll("\.", "")); }
return w;
}


//lIMPIA todos los campos numericos de un formulario
function clean_numbers(formid){
    $(formid+" .number-format").each( function( indice, obj){    quitarSeparador( obj); } );

}

//Recuperar formato numerico de los campos
function rec_formato_numerico(formid){ 
  $(formid+" .number-format").each( function( indice, obj){    numero_con_puntuacion( obj); } );
}


//Permite solo entrada numerica
//A la vez, da formato de millares al valor del campo que se esta controlando
function input_number_millares(ev){
    if( ev.data != undefined) 
    {
        if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }
    }
     //Formato de millares
    let val_Act= ev.target.value;  
  val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/g), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
    } 
    


    //convertir una cadena numerica a formato de millares
function numero_con_puntuacion( ev){
     
    let val_Act= ev;
    if( typeof ev == "object"){
        if("target" in ev)
        val_Act= ev.target.value;
        else 
        val_Act= ev.value;
    }

    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
    if( typeof ev == "object"){ 
        if("target" in ev)
        $( ev.target).val(  enpuntos);
        else
        $( ev).val(  enpuntos);
        }
    else return enpuntos;
}
    //Exclusivamente numeros
        function input_number( ev){
            if( ev.data == undefined) return; 
            if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
            ev.target.value= 
            ev.target.value.substr( 0, ev.target.selectionStart-1) + 
            ev.target.value.substr( ev.target.selectionStart );
            }
        }

 function validarSpecialChars(ev){
     if( ev.data == undefined) return;
     if( ev.data.charCodeAt() == 39  )
     ev.target.value=  
     ev.target.value.substr( 0, ev.target.selectionStart-1) + '"'+
            ev.target.value.substr( ev.target.selectionStart );
     
 }




 function cleanForm( formid){
    let form= document.getElementById( formid);
    let campos= form.elements;
    Array.prototype.forEach.call(  campos, function (PARAM) {
        
        PARAM.value= "";
    });

 }
        function guardar(ev, success){
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
        beforeSend: function(){ 
            $("#spinner_system").css("display", "block")
       
        },
        success: function(res){  $("#spinner_system").css("display", "none"); success(res);},
        error: function(res){
            $("#spinner_system").css("display", "none") 
            new PNotify({
                                  title: 'ERROR',
                                  text: '',
                                  type: 'danger',
                                  styling: 'bootstrap3'
                              });  
         }
    };
    if ( ev.target.enctype ==  "multipart/form-data"){
        SETTING.processData= false; SETTING.contentType= false;
    }
    $.ajax(  SETTING)
  }

  

function get_custom( url, success){
   $.ajax( {
        url:  url,  
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        beforeSend: function(){ 
            $("#spinner_system").css("display", "block");
       
        },
        success: function(res){  $("#spinner_system").css("display", "none"); success(res);},
        error: function(res){
            $("#spinner_system").css("display", "none") 
            new PNotify({
                                  title: 'ERROR',
                                  text: '',
                                  type: 'danger',
                                  styling: 'bootstrap3'
                              });  
         }
    });
}

/*
  window.onload= function(){
      autocompletado();
      $("div.stepContainer.content").css("width", "100%");
      $("div.stepContainer.content").css("height", "100%");
      //FECHAS
    $("input[type=date]").each(  function(index, elemento){
        if(  this.value =="" )
            $(elemento).css("color", "white");
            $(elemento).bind("change", function(){
                if( this.value ==""  ||  this.value == undefined){
                    console.log( this.value );
                    $(  this  ).css("color", "white");
                    return;
                }
                $(  this  ).css("color", "black");
            })
        });//end fechas 
  }*/
    </script>

</body>

</html>