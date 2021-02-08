<!-- INI FORM -->
<?php

use App\Helpers\Utilidades;

echo form_open("prestamo/cobro", ['id'=> "cobro-form", 'onsubmit'=>'guardarCobro(event)' ])
?>
 <!-- *********************CABECERA COBRO *****************-->
 <!-- ID DE PRESTAMO --> 
 <input type="hidden" name="CABECERA[IDPRESTAMO]" value="<?=$prestamo_dato->IDNRO?>">
 <!-- FECHA --> 
 <input type="hidden" name="CABECERA[FECHA]" value="<?= date("Y-m-j")?>">
  <!-- CAJERO --> 
  <input type="hidden" name="CABECERA[CAJERO]" value="<?=session("ID")?>">
 <!-- ID DE DEUDOR --> 
<input id="DEUDOR" type="hidden" name="CABECERA[DEUDOR]" value="<?=$deudor->IDNRO?>">
 <!-- CAJA --> 
 <input type="hidden" name="CABECERA[CAJA]" value="<?=session("CAJA")?>">

<!-- ESTADO COBRO POR DEFECTO "A" --> 
<input type="hidden" name="CABECERA[ESTADO]" value="A">
 <!-- *********************CABECERA COBRO *****************-->


 <!-- *********************DATOS ACERCA DEL MONTO TOTAL PRESTADO *****************-->
 <input id="cate-monto"     type="hidden"     value="<?= Utilidades::number_f( $monto->MONTO )?>" >
 <input  id="cate-formato"   type="hidden" value="<?=!isset($monto) ? "" :  $monto->FORMATO?>"> 
 <input  id="cate-nro-cuo"   type="hidden"  value="<?= $monto->NRO_CUOTAS?>" >
 <input  id="cate-cuotas"  type="hidden"   value="<?= $monto->CUOTA?>" >
 
 

 <div class="container"><button type="submit" class="btn btn-danger">COBRAR</button></div>
 <div class="row">

 <div class="col-xs-12 col-md-4">
 <label style="font-size: 12pt;font-weight: 600;color:#363636;" >TOTAL A COBRAR</label>    
 <span  class="label label-warning" style="font-size: 14pt; color: blue;  font-weight: 600;background-color: #fbe862;"  id="TOTALCOBRO" >0</span>

  </div>
  <div class="col-xs-12 col-md-4"> 
    <label style="font-size: 12pt;font-weight: 600;color:#363636;" >TOTAL IMPORTE</label>
    <span class="label label-warning"  id="TOTALIMPORTE"   style="font-size: 14pt; color: blue;background-color: #fbe862;"> 0 </span>
  
    
  </div>
  <div class="col-xs-12 col-md-4">
    <label style="font-size: 12pt;font-weight: 600;color:#363636;" >VUELTO:</label> 
    <span  class="label label-warning" id="SALDO"  style="font-size: 14pt; color: blue;background-color: #fbe862;">0</span>
      
  </div>
  </div>
 

  <div class="row">

  <div class="col-xs-12 col-md-5">

        <!-- *********************MODALIDADES DE COBRO VARIAS*****************-->
        <!-- *********************EFECTIVO*****************-->

        
          
          <div class="row">
            <div class="col-xs-12 col-md-6">
          
            <fieldset>
              <legend>IMPORTE</legend>
                  <div class="form-group"><label class="sobrio" >IMPORTE EFECTIVO:</label>
                  <input id="EFECTIVO" oninput="totalizar_importe(event)" maxlength="10" style="font-size: 12pt; color: blue;" class="form-control numero" type="text" name="CABECERA[EFECTIVO_T]" value="0">
                  </div>

                  <div class="form-group"><label class="sobrio" >IMPORTE CHEQUE:</label>
                  <input id="CHEQUE" oninput="totalizar_importe(event)" maxlength="10" style="font-size: 12pt; color: blue;" class="form-control numero" type="text" name="CABECERA[CHEQUE_IMPO]" value="0">
                </div>

                  <div class="form-group"><label  class="sobrio">IMPORTE TARJETA:</label>
                  <input id="TARJETA" oninput="totalizar_importe(event)" maxlength="10" style="font-size: 12pt; color: blue;" class="form-control numero" type="text" name="CABECERA[TARJE_IMPO]" value="0">
                </div>
            </fieldset>

            </div>
            
          <!-- *********************CHEQUE*****************-->
         

        <div class="col-xs-12  col-md-6"> 
        <fieldset>
          <legend>Detalles del cobro</legend>
          
            <div class="form-group"><label  class="sobrio">BANCO EMISOR DE CHEQUE:</label> 
            <input maxlength="30" style="font-size: 12pt; color: blue;" class="form-control" type="text" name="CABECERA[CHEQUE_BANC]" value=""> </div>
            
              <div class="form-group"><label class="sobrio" >NÚMERO CHEQUE:</label>
              <input maxlength="20" style="font-size: 12pt; color: blue;" class="form-control" type="text" id="CABECERA[[CHEQUE_NRO]" value="0">
            </div> 
            <!--TARJETA --> 
                <div class="form-group"><label class="sobrio" >TIPO TARJETA:</label>
                  <div class="radio">
                <label class="prestyle"><input type="radio" name="CABECERA[TARJE_TIPO]" value="C">Crédito</label>

                <label  class="prestyle"><input type="radio" name="CABECERA[TARJE_TIPO]" value="D">Débito</label>
                </div>
                </div>
            <div class="form-group"><label class="sobrio" >N° Voucher:</label>
              <input maxlength="20" style="font-size: 12pt; color: blue;" class="form-control" type="text" name="CABECERA[TARJE_VOUCH]" value="0">
            </div>
        </fieldset>
      
      </div>


        </div><!--End row-->
</div>


<div class="col-xs-12 col-md-7">


<table  id="cuotas" class="table table-hover">
    <thead> <tr>  <th>#</th>  <th>MONTO</th>  <th>VENCIMIENTO</th><th>SALDO</th>  <th>COBRAR</th> </tr>
    </thead>
    <tbody>
    <?php  
    $NRO_CUOTA= 1;
    foreach( $cuotas as $cuo): ?>     
      
      <tr  style="font-size: 10pt !important;color: #525252;" >  
      <td><?=$NRO_CUOTA?></td> 
       <td><?= Utilidades::number_f( $cuo->MONTO )?></td>  
       <td><?= Utilidades::fecha_f( $cuo->VENCIMIENTO )?></td> 
       <td><?= Utilidades::number_f( $cuo->SALDO ) ?> </td>
       <td style="padding: 0px;"> 
        <input style=" margin: 0px;width: 25px;height: 25px; transform: scale(2);" class="form-control" onchange="marcacion(event)" name="ESTADO[]" type="checkbox" value="<?=$cuo->IDNRO?>" >
       </td> 
      </tr>
      
    <?php 
    $NRO_CUOTA++;
   endforeach; ?>                     
    </tbody>
  </table>
</div>


 </div><!--End master row-->





 
  





</form>