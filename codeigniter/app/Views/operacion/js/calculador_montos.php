<?= view("operacion/js/calc_vencimientos") ?>
<?= view("operacion/js/sistema_de_calculo") ?>

<script>
    /*****  Datos  ************ */
    /*
    De la BD: 

        BCP_INTERES
        DIASXMES
        DIASXANIO
        IVA
        MESESXANIO
        GASTOS_ADM_PORCE
        SEGURO_CANCEL
        SEGURO_3ROS
        MORA_PORCE
        PUNITORIO PORCE 
        INTERES_PORCE (CALCULADO)
*/
    var parametrosCalc = {};

     
    /** 
     * valores Calculados: 
     * 
     * TOTAL_INTERESES
     * TOTAL_IVA_INTERESES
     * TOTAL_GASTOS_ADMIN
     * TOTAL_SEGURO_CANCEL
     * TOTAL_SEGURO_3ROS
     * TOTAL_NETO_DESEMBOLSAR
     * MONTO_CREDITO_FINAL
     */
    var operacionModel = {};





    function getTipoDeCalculoElegido(  ){
        return SISTEMA_DE_AMORTIZACION[ $("#SISTEMA").val() ];
    }



    /** Inicializar
     * Limpiar las entradas de usuario antes de empezar el calculo
     * 
     */

    async function iniciar_calculos_de_operacion() {

        if (Object.keys(parametrosCalc).length == 0) {
            await obtener_parametros();
            await obtener_data_producto_financiero();
        }

        /**Entradas de usuario  */
        let MONTO_CREDITO = formatoNumerico.parsearInt(formValidator.limpiarNumero($("input[name=CREDITO]").val()));
        let NRO_CUOTAS = formatoNumerico.parsearInt(formValidator.limpiarNumero($("input[name=NRO_CUOTAS]").val()));
        let PRIMER_VENCIMIENTO = $("#PRIMER_VENCIMIENTO").val();
        let userInputs = {
            MONTO_CREDITO: MONTO_CREDITO,
            NRO_CUOTAS: NRO_CUOTAS,
            PRIMER_VENCIMIENTO: PRIMER_VENCIMIENTO
        };

       // Object.assign(sistemaFrances, parametrosCalc);
        //Object.assign(sistemaFrances, userInputs);
        getTipoDeCalculoElegido().setUserInputs(   userInputs );
        getTipoDeCalculoElegido().setParametros(   parametrosCalc );
        getTipoDeCalculoElegido().init();

        //guardar
        operacionModel.CREDITO = MONTO_CREDITO;
        operacionModel.NRO_CUOTAS = NRO_CUOTAS;
        operacionModel.SEGURO_CANCEL =  getTipoDeCalculoElegido().RESULTADOS.SEGURO_CANCEL;
        operacionModel.SEGURO_3ROS =  getTipoDeCalculoElegido().RESULTADOS.SEGURO_3ROS;
        operacionModel.GASTOS_ADM =  getTipoDeCalculoElegido().RESULTADOS.GASTOS_ADM;
        operacionModel.CAPITAL_DESEMBOLSO =  getTipoDeCalculoElegido().RESULTADOS.CAPITAL_DESEMBOLSO;
        operacionModel.TOTAL_INTERESES =  getTipoDeCalculoElegido().RESULTADOS.TOTAL_INTERESES;
        operacionModel.INTERES_PORCE = parametrosCalc.INTERES_PORCE;
        operacionModel.INTERES_IVA_PORCE = parametrosCalc.INTERES_IVA_PORCE;
        operacionModel.TOTAL_INTERESES_IVA =  getTipoDeCalculoElegido().RESULTADOS.TOTAL_INTERESES_IVA;
        operacionModel.TOTAL_PRESTAMO =  getTipoDeCalculoElegido().RESULTADOS.TOTAL_PRESTAMO;
        operacionModel.CUOTA_IMPORTE =  getTipoDeCalculoElegido().RESULTADOS.CUOTA_IMPORTE;
        operacionModel.PRIMER_VENCIMIENTO = PRIMER_VENCIMIENTO;



        mostrar_resultados_calculo();
    }












    /*
    Paso PRIMERO 
    */
    async function obtener_data_producto_financiero() {

        let idNro = $("#PRODUCTO_FINA").val();
        let url__ = "<?= base_url("producto-finan/get") ?>/" + idNro; //header formato: json-raw
        let req = await fetch(url__, {
            headers: {
                formato: "json-raw",
                'CHECK-AUTH': "S"
            }
        });
        let resp = await req.json();

        //Producto financiero 
        if ("auth_error" in resp) {
            alert(resp.auth_error);
            window.location = resp.redirect;
        }

        Object.assign(parametrosCalc, resp);
    }


    async function obtener_parametros() {
        /*
        SEGURO_CANCEL
        SEGURO_3ROS
        GAST_ADM_PORCE
        INTERES_PORCE
        IVA
        DIASXANIO
        MESESXANIO
        DIASXMES
        */

        if (Object.keys(parametrosCalc).length > 0) return;

        //PARAMETROS GENERALES 
        let url__ = "<?= base_url("parametros/get") ?>"; //header formato: json-raw
        let req = await fetch(url__, {
            headers: {
                formato: "json-raw",
                'CHECK-AUTH': "S"
            }
        });
        let resp = await req.json();

        //Producto financiero 
        if ("auth_error" in resp) {
            alert(resp.auth_error);
            window.location = resp.redirect;
        }

        Object.assign(parametrosCalc, resp);

    }



    function mostrar_resultados_calculo() {

        $("#SEGURO_CANCEL").val(formatoNumerico.darFormatoEnMillares(operacionModel.SEGURO_CANCEL, 0));
        $("#SEGURO_3ROS").val(formatoNumerico.darFormatoEnMillares(operacionModel.SEGURO_3ROS, 0));
        $("#GASTOS_ADM").val(formatoNumerico.darFormatoEnMillares(operacionModel.GASTOS_ADM, 0));
        $("#CAPITAL_DESEMBOLSO").val(formatoNumerico.darFormatoEnMillares(operacionModel.CAPITAL_DESEMBOLSO, 0));
        $("#TOTAL_PRESTAMO").val(formatoNumerico.darFormatoEnMillares(operacionModel.TOTAL_PRESTAMO, 0));
        $("#INTERESES").val(formatoNumerico.darFormatoEnMillares(operacionModel.TOTAL_INTERESES, 0));
        $("#INTERES_IVA").val(formatoNumerico.darFormatoEnMillares(operacionModel.TOTAL_INTERESES_IVA, 0));
        $("#CUOTA_IMPORTE").val(formatoNumerico.darFormatoEnMillares(operacionModel.CUOTA_IMPORTE, 0));
    }
</script>