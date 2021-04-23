<style>
    .Subtitulo {
        text-align: center;
        font-weight: 600;
        border-bottom: 1px solid black;
    }

    tr td span {
        font-weight: 600;
    }
</style>


<?php
$CEDULA = $cliente->CEDULA;
$NOMBRE_COMPLETO = $cliente->NOMBRES . ' ' . $cliente->APELLIDOS;
$FECHA_NAC = $cliente->FECHA_NAC == "" ? "****" :  $cliente->FECHA_NAC;
$DOMICILIO =  $cliente->DOMICILIO == "" ? "****" :  $cliente->DOMICILIO;
$TELEFONO = $cliente->TELEFONO == "" ? "****" :  $cliente->TELEFONO;
$CELULAR = $cliente->CELULAR == "" ? "****" :  $cliente->CELULAR;
$CIUDAD = $cliente->CIUDAD;
$BARRIO = $cliente->BARRIO == "" ? "****" :  $cliente->BARRIO;
$EMAIL = $cliente->EMAIL == ""  ? "****" : $cliente->EMAIL;

//Datos del credito 
$IDOPERACION = $operacion->IDNRO;
$CODIGO_OPERACION = $operacion->LETRA . $operacion->CORRELATIVO;
$CREDITO = $operacion->CREDITO;
$NRO_CUOTAS = $operacion->NRO_CUOTAS;
$CUOTA_IMPORTE = $operacion->CUOTA_IMPORTE;
$SEGURO_CANCEL = $operacion->SEGURO_CANCEL;
$SEGURO_3ROS = $operacion->SEGURO_3ROS;
$GASTOS_ADM = $operacion->GASTOS_ADM;
$TOTAL_INTERESES = $operacion->TOTAL_INTERESES;
$TOTAL_INTERESES_IVA = $operacion->TOTAL_INTERESES_IVA;
$TOTAL_PRESTAMO = $operacion->TOTAL_PRESTAMO;
$INTERES_PORCE = $operacion->INTERES_PORCE;
$EMPRESA = $empresa->DESCR;

?>

<table>
    <thead>
        <tr>
            <th class="Subtitulo" colspan="4">Datos personales</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span>CI°: </span><?= $CEDULA ?> </td>
            <td><span>Nombres: </span><?= $NOMBRE_COMPLETO ?></td>
            <td><span>Fecha de Nac.: </span><?= $FECHA_NAC ?></td>
            <td><span>Ciudad: </span><?= $CIUDAD ?></td>
        </tr>
        <tr>
            <td><span>Domicilio: </span><?= $DOMICILIO ?></td>
            <td><span>Tel.: </span><?= $TELEFONO ?></td>
            <td><span>Cel.: </span><?= $CELULAR ?></td>
            <td><span>Barrio: </span><?= $BARRIO ?></td>
        </tr>
        <tr>


            <td><span>Email: </span><?= $EMAIL ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>


<table>
    <thead>
        <tr>
            <th class="Subtitulo" colspan="10">Datos del crédito</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span>N° de operación: </span> </td>
            <td> <?= $IDOPERACION ?></td>

            <td><span>Código: </span> </td>
            <td> <?= $CODIGO_OPERACION ?></td>

            <td><span>Monto del capital: </span> </td>
            <td> <?= $CREDITO ?></td>

            <td><span>Monto del préstamo: </span></td>
            <td><?= $TOTAL_PRESTAMO ?></td>

            <td><span>Cuotas: </span></td>
            <td><?= $NRO_CUOTAS ?></td>

        </tr>

        <tr>
            <td><span>Tipo de operación: </span></td>
            <td><?= "**" ?></td>

            <td><span>Empresa: </span></td>
            <td><?= $EMPRESA  ?></td>

            <td><span>Tasa de interés: </span></td>
            <td><?= $INTERES_PORCE  ?></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>N°</th>
            <th>Cuota</th>
            <th>Amortización</th>
            <th>Interés</th>
            <th>IVA 10%</th>
            <th>Saldo</th>
            <th>Vencimiento</th>
        </tr>
    </thead>
    <tbody>
    <?php  foreach( $cuotas as $cuo):
    
    $CAPITAL= $cuo->MONTO - $cuo->INTERES;
    $MONTO_AMORTIZACION =  $CAPITAL- $cuo->IVA;
    
    ?>
    <tr>
    <td><?= $cuo->NUMERO?> </td>
    <td><?= $cuo->MONTO?> </td>
    <td><?= $cuo->CAPITAL?> </td>
    <td><?= $cuo->INTERES?> </td>
    <td><?= $cuo->IVA?> </td>
    <td><?= $cuo->NUMERO?> </td>
    </tr>
    <?php  endforeach; ?>
    </tbody>
</table>