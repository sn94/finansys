<div class="container">

    <div style="display: grid;grid-template-columns: 50% 50%;">
        <label for="">N° CUOTAS A PAGAR:</label>
        <input type="text" id="CUOTAS_PAGADAS" name="CUOTAS_PAGADAS" class="form-control entero" required>
    </div>

    <div style="display: grid;grid-template-columns: 50% 50%;">
        <label for="">IMPORTE A PAGAR:</label>
        <input type="text" readonly id="IMPORTE_PAGADO" name="IMPORTE_PAGADO" class="form-control entero">
    </div>

    <div style="display: grid;grid-template-columns: 50% 50%;">
        <label for="">MORA:</label>
        <input type="text" readonly id="MORA" name="MORA" class="form-control entero">
        <input type="hidden" id="MORA_UNITARIA" name="MORA_UNITARIA">
    </div>

    <div style="display: grid;grid-template-columns: 50% 50%;">
        <label for="">IVA MORA:</label>
        <input type="text" readonly id="IVA_MORA" name="IVA_MORA" class="form-control entero">
    </div>
    <div style="display: grid;grid-template-columns: 50% 50%;">
        <label for="">PUNITORIO:</label>
        <input type="text" readonly id="PUNITORIO" name="PUNITORIO" class="form-control entero">
    </div>

    <div style="display: grid;grid-template-columns: 50% 50%;">
        <label for="">IVA PUNITORIO:</label>
        <input type="text" readonly id="IVA_PUNITORIO" name="IVA_PUNITORIO" class="form-control entero">
    </div>
    <div style="display: grid;grid-template-columns: 50% 50%;">
        <label for="">TOTAL A PAGAR:</label>
        <input type="text" readonly id="GRAN_TOTAL" name="TOTAL_ABSOLUTO" class="form-control entero">
    </div>

</div>



<script>
    var PARAMETROS = {};

    /**
     *  
     * @fields
     * IDNRO,BCP_INTERES,SALARIO_MIN,JORNAL_MIN,DIASXMES,DIASXANIO,IVA,MESESXANIO,GAST_ADM_PORCE,SEGURO_CANCEL,
     * SEGURO_3ROS,MORA_PORCE,PUNITORIO_PORCE
     * 
     * 
     */
    async function obtener_parametros() {

        let url__ = "<?= base_url("parametros/get") ?>";
        let req = await fetch(url__);
        PARAMETROS = await req.json();
        if(  "auth_error" in PARAMETROS )
        {
            alert(  PARAMETROS.auth_error );
            window.location=  PARAMETROS.redirect;
        }
        
    }


    function calcularTotalDiasAtraso() {

        let nroCuotasPagar = formValidator.limpiarNumero($("#CUOTAS_PAGADAS").val());

        let tt = cuotas_data_model.filter((ar) => ar.ESTADO == "P")
            .slice(0, parseInt(nroCuotasPagar)).
        map((ar) => ar.ATRASO).
        reduce((acum, ar) => {
            return parseInt(acum) + parseInt(ar);
        }, 0);
        return tt;
    }



    function calcularDescuentoNormalMax(){

    }
    function calcularDescuentoCancelacionMax(){

    }


    
    function calcularTotalPagar(ev) {

        let nroCuotasPagar = ev.target.value;

        nroCuotasPagar = formValidator.limpiarNumero(nroCuotasPagar);

        nroCuotasPagar = formatoNumerico.parsearInt(nroCuotasPagar);

        //Total en importe de cuotas elegidas
        let importeTotalCuotas = formValidator.limpiarNumero(cuotas_data_model[0].MONTO);
        importeTotalCuotas = formatoNumerico.parsearInt(importeTotalCuotas) * nroCuotasPagar;
        $("#IMPORTE_PAGADO").val(formatoNumerico.darFormatoEnMillares(importeTotalCuotas, 0));


        //Calculo de Mora
        let totalAtraso = calcularTotalDiasAtraso();

        let porcenMora = formatoNumerico.parsearFloat(formValidator.limpiarNumero(PARAMETROS.MORA_PORCE));
        console.log(porcenMora);
        let importeMoraUnitaria = ((importeTotalCuotas * porcenMora) / 10000);
        let importeMora = importeMoraUnitaria * totalAtraso;
        importeMora = (isNaN(importeMora) || !isFinite(importeMora)) ? 0 : importeMora;

        $("#MORA").val(formatoNumerico.darFormatoEnMillares(importeMora, 0));
        $("#MORA_UNITARIA").val(importeMoraUnitaria);
        //IVA mora
        let ivaPorcen = formatoNumerico.parsearFloat(formValidator.limpiarNumero(PARAMETROS.IVA));
        let IVAmora = importeMora * (ivaPorcen / 100);
        $("#IVA_MORA").val(formatoNumerico.darFormatoEnMillares(IVAmora, 0));

        //Punitorio
        let porcenPuni = formatoNumerico.parsearFloat(formValidator.limpiarNumero(PARAMETROS.PUNITORIO_PORCE));
        let basePunitorio = IVAmora + importeMora;
        let importePunitorio = basePunitorio * (porcenPuni / 100);
        $("#PUNITORIO").val(formatoNumerico.darFormatoEnMillares(importePunitorio, 0));
        //IVA punitorio
        let IVApunitorio = importePunitorio * (ivaPorcen / 100);
        $("#IVA_PUNITORIO").val(formatoNumerico.darFormatoEnMillares(IVApunitorio, 0));

        //Total SobreCarga: Mora  , punitorio e IVA
        let totalSobrecarga = importeMora + IVAmora + importePunitorio + IVApunitorio;
        $("#MORA_UNITARIA").val(totalSobrecarga);
        //Total de totales a Pagar
        let granTotal = importeTotalCuotas + importeMora + IVAmora + importePunitorio + IVApunitorio;
        $("#GRAN_TOTAL").val(formatoNumerico.darFormatoEnMillares(granTotal, 0));
    }
</script>