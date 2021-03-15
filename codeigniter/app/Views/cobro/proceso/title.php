<?php

use App\Helpers\Utilidades;
use App\Models\Empresa_model;
use App\Models\Usuario_model;

$CEDULA_CLIENTE = $prestamo_dato->CEDULA;
$NOMBRE_CLIENTE = $prestamo_dato->NOMBRES;
$CREDITO =  Utilidades::number_f($prestamo_dato->CREDITO);
$IMPORTE_CUOTA =  Utilidades::number_f($prestamo_dato->CUOTA_IMPORTE);
$NRO_CUOTAS =  $prestamo_dato->NRO_CUOTAS;
$COD_OPERACION =  $prestamo_dato->LETRA . $prestamo_dato->CORRELATIVO;
$EMPRESA = (new Empresa_model())->where("IDNRO", $prestamo_dato->EMPRESA)->first();
//rEGISTRADO POR
$usuario_reg =  (new Usuario_model())->where("IDNRO", $prestamo_dato->FUNCIONARIO)->first();
$REGISTRADO_POR =   is_null($usuario_reg) ?   "***"  :    $usuario_reg->NICK;
//garantes
$GARANTE1 =  $prestamo_dato->GARANTE1_CI . "-" . $prestamo_dato->GARANTE1_NOM;
$GARANTE2 =  $prestamo_dato->GARANTE2_CI . "-" . $prestamo_dato->GARANTE2_NOM;
$GARANTE3 =  $prestamo_dato->GARANTE3_CI . "-" . $prestamo_dato->GARANTE3_NOM;
?>

<style>
    .CAJA-HEADER dt,
    .CAJA-HEADER dd {
        font-size: 12px !important;
        text-transform: uppercase;
    }
</style>




<fieldset class="bg-primary">
    <legend> <label> CAJA</label></legend>
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="">CÉDULA: </label>
            <input class="form-control" type="text" value="<?= $CEDULA_CLIENTE ?>">
            <label for="">CLIENTE: </label>
            <input class="form-control" type="text" value="<?= $NOMBRE_CLIENTE ?>">
            <label for="">CÓD.OPERACIÓN: </label>
            <input class="form-control" type="text" value="<?= $COD_OPERACION ?>">
            <label for="">EMPRESA: </label>
            <input class="form-control" type="text" value=" <?= $EMPRESA->DESCR ?> ">

        </div>
        <div class="col-12 col-md-4">

            <label for=""> REGISTRADO POR: </label>
            <input class="form-control" type="text" value="<?= $REGISTRADO_POR ?>">
            <label for="">CRÉDITO: </label>
            <input class="form-control" type="text" value="<?= $CREDITO ?> &nbsp;GS.">

            <label for="">IMP.CUOTA:</label>
            <input class="form-control" type="text" value="<?= $IMPORTE_CUOTA ?>">
            <label for="">N° CUOTAS: </label>
            <input class="form-control" type="text" value="<?= $NRO_CUOTAS ?>">

        </div>
        <div class="col-12 col-md-4">

            <label for="">GARANTE 1: </label>
            <input class="form-control" type="text" value="<?= $GARANTE1 ?>">
            <label for="">GARANTE 2: </label>
            <input class="form-control" type="text" value="<?= $GARANTE2 ?>">
            <label for="">GARANTE 3:</label>
            <input class="form-control" type="text" value="<?= $GARANTE3 ?>">



        </div>
    </div>
</fieldset>