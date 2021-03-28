<script>
    var parametrosCalc = {};


    async function obtener_parametros() {

        let url__ = "<?= base_url("parametros/get") ?>";
        let req = await fetch(url__);
        let resp = await req.json();
        parametrosCalc = resp;

        let BCP_PORCEN = Math.round((parseFloat(formValidator.limpiarNumero(parametrosCalc.BCP_INTERES)) / 12) * 1e8) / 1e8;

        let PORCEN_IVA= formatoNumerico.darFormatoEnMillares(  formValidator.limpiarNumero(parametrosCalc.IVA)  , 0);

        $("#PORCEN_INTERES").val(formatoNumerico.darFormatoEnMillares(BCP_PORCEN, 8));
        $("#PORCEN_IVA_INTERES").val( PORCEN_IVA );
    }



    function numeroDeMillones(numero) {
        let base = 1000000;
        let parame = numero;
        let numeroMillones = 1;
        if (numero == base) return numeroMillones;
        if (numero < base) return 0;

        while (parame > base) {
            parame -= base;
            if (parame < base) break;
            numeroMillones++;

        }
        return numeroMillones;

    }


    async function calcular_montos() {


        await obtener_parametros();

        /**Capital NETO A DESEMBOLSAR */
        let monto_ = formatoNumerico.parsearInt(formValidator.limpiarNumero($("input[name=CREDITO]").val()));
        /**Calculo de gastos en base al monto del crédito */

        let seguro_cancel = (parseInt( formValidator.limpiarNumero(parametrosCalc.SEGURO_CANCEL) ) ) * numeroDeMillones(monto_);
        let seguro_3ros = (parseInt( formValidator.limpiarNumero(parametrosCalc.SEGURO_3ROS) )) * numeroDeMillones(monto_);
        let gastos_adm = (parseFloat( formValidator.limpiarNumero(parametrosCalc.GAST_ADM_PORCE) ) / 100) * monto_;

        $("#SEGURO_CANCEL").val(formatoNumerico.darFormatoEnMillares(seguro_cancel, 0));
        $("#SEGURO_3ROS").val(formatoNumerico.darFormatoEnMillares(seguro_3ros, 0));
        $("#GASTOS_ADM").val(formatoNumerico.darFormatoEnMillares(gastos_adm, 0));

        /**Capital Neto a desembolsar**** */
        let capital_neto_a_desem = monto_ + seguro_cancel + seguro_3ros + gastos_adm;
        $("#CAPITAL_DESEMBOLSO").val(formatoNumerico.darFormatoEnMillares(capital_neto_a_desem, 0));
        /**     ***   ***   ***   *** *** ****  */

        /** Monto Total del prestamo mas intereses + IVA */
        let nro_cuotas = formatoNumerico.parsearInt(formValidator.limpiarNumero($("input[name=NRO_CUOTAS]").val()));
        let interes_porcen = parseFloat(formValidator.limpiarNumero($("#PORCEN_INTERES").val())) / 100; //8 dec

        let intereses = (monto_ * (interes_porcen)) * nro_cuotas;
        let intereses_iva_porce = parseFloat(formValidator.limpiarNumero($("#PORCEN_IVA_INTERES").val())) / 100;
        let iva_intereses = intereses * (intereses_iva_porce);

        let total_prestamo = capital_neto_a_desem + intereses + iva_intereses;
        $("#MONTO-PRESTAMO").val(formatoNumerico.darFormatoEnMillares(total_prestamo, 0));
        $("#INTERESES").val(formatoNumerico.darFormatoEnMillares(intereses, 0));
        $("#INTERES_IVA").val(formatoNumerico.darFormatoEnMillares(iva_intereses, 0));
        /**  */
        /*** Calculo de importe de cuota */
        let param_calc_cuota = {
            CAPITAL_A_DESENVOL: capital_neto_a_desem,
            TASA_INTERES: interes_porcen,
            NRO_CUOTAS: nro_cuotas
        };
       
        let importe_de_la_cuota = sistemaFrances.calculaMontoCuota(param_calc_cuota);


        importe_de_la_cuota = (!isFinite(importe_de_la_cuota) || isNaN(importe_de_la_cuota)) ? 0 : importe_de_la_cuota;
        $("#CUOTA_IMPORTE").val(formatoNumerico.darFormatoEnMillares(importe_de_la_cuota, 0));
    }
</script>