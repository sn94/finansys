<?= $this->extend("layouts/index") ?>
<?= $this->section("contenido") ?>
 <!-- page content -->
 
 <?php 

$clientes= isset($clientes) ? $clientes : 0;
$pendientes= isset(  $pendientes)?  $pendientes : 0;
$aprobados= isset(  $aprobados)?  $aprobados : 0;
$liquidados= isset(  $liquidados)?  $liquidados : 0;
$rechazados= isset(  $rechazados)?  $rechazados : 0;
 ?>
                <!-- top tiles -->
                <div class="row tile_count">
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Total Clientes</span>
                        <div class="count"><?=$clientes?></div>
                        
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                        <span class="count_top"> <i class="fa fa-user"></i> </i>Solicitudes pendientes</span>
                        <div class="count"><?=$pendientes?></div>
                         
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i>Aprobados</span>
                        <div class="count green"><?=$aprobados?></div>
                       
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Liquidados</span>
                        <div class="count"><?=$liquidados?></div>
                      
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Rechazados</span>
                        <div class="count"><?=$rechazados?></div>
                       
                    </div>
                   
                </div>
                <!-- /top tiles -->

             
                <br />

                <!--graficos -->
                <div id="rating-cobros" style="height: 500px;">

                </div>
           
            <!-- /page content -->
<?= $this->endSection() ?>