<?= view("operacion/js/calc_vencimientos") ?>
<?= view("operacion/js/sistema_de_calculo") ?>

<script>
    /*****  Datos  ************ */

    var productosFinancierosList = [];
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






    function getTipoDeCalculoElegido() {
        return SISTEMA_DE_AMORTIZACION[$("#SISTEMA").val()];
    }



    /** Inicializar
     * Limpiar las entradas de usuario antes de empezar el calculo
     * 
     */


    function mostrarMensajeDelSistema(TEXT) {
        $("#loaderplace-textual p").text(TEXT);
        $("#loaderplace-textual").removeClass("d-none");
    }

    function ocultarMensajeDelSistema() {
        $("#loaderplace-textual p").text("");
        $("#loaderplace-textual").addClass("d-none");
    }

    async function descargarProductosFinancieros() {
        if (productosFinancierosList.length == 0) {
            let url__ = "<?= base_url("producto-finan/index") ?>"; //header formato: json-raw
            let reqProdFina = await fetch(url__, {
                headers: {
                    formato: "json",
                    'CHECK-AUTH': "S"
                }
            });
            let respProdFina = await reqProdFina.json();
            productosFinancierosList = respProdFina;
            return respProdFina;
        }
        return false;
    }

    function verificarProductoFinanciero(onchange_e) {
        //Se cambiaran los parametros de calculo segun el monto del credito y numero de cuotas
        let montoCredito = formatoNumerico.parsearInt(formatoNumerico.limpiarNumero($("#CREDITO").val()));
        let nroCuotas = formatoNumerico.parsearInt(formatoNumerico.limpiarNumero($("#NRO_CUOTAS").val()));

        let productoFinaCoincidente = productosFinancierosList.filter(function(producto) {

            return montoCredito >= parseInt(producto.MONTO_MINIMO) && montoCredito <= parseInt(producto.MONTO_MAXIMO) &&
                nroCuotas <= parseInt(producto.NCUOTAS_MAXIMO) && nroCuotas >= parseInt(producto.NCUOTAS_MINIMO);

        });
        if (productosFinancierosList.length == 0) {
            alert("No se registran productos financieros");
            return;
        }
        if (onchange_e != undefined && montoCredito != 0 && nroCuotas != 0 && productoFinaCoincidente.length == 0) {
            alert("No se encontro ningún producto que se adecue a las características del crédito")
        }
        console.log(productoFinaCoincidente);
    }


    async function cambiarSistema() {


        mostrarMensajeDelSistema("Verificando producto financiero");

        let respProdFina = await descargarProductosFinancieros();

        ocultarMensajeDelSistema();
        //Producto financiero 
        if (respProdFina && ("auth_error" in respProdFina)) {
            alert(respProdFina.auth_error);
            window.location = respProdFina.redirect;
        }
        verificarProductoFinanciero();

        iniciar_calculos_de_operacion();

    }




    async function iniciar_calculos_de_operacion() {

        if (Object.keys(parametrosCalc).length == 0) {
            mostrarMensajeDelSistema("Descargando parámetros de cálculo");
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
        getTipoDeCalculoElegido().setUserInputs(userInputs);
        getTipoDeCalculoElegido().setParametros(parametrosCalc);
        getTipoDeCalculoElegido().init();
        // getTipoDeCalculoElegido().generarCuotas();

        //guardar
        operacionModel.CREDITO = MONTO_CREDITO;
        operacionModel.NRO_CUOTAS = NRO_CUOTAS;
        operacionModel.SEGURO_CANCEL = getTipoDeCalculoElegido().RESULTADOS.SEGURO_CANCEL;
        operacionModel.SEGURO_3ROS = getTipoDeCalculoElegido().RESULTADOS.SEGURO_3ROS;
        operacionModel.GASTOS_ADM = getTipoDeCalculoElegido().RESULTADOS.GASTOS_ADM;
        operacionModel.CAPITAL_DESEMBOLSO = getTipoDeCalculoElegido().RESULTADOS.CAPITAL_DESEMBOLSO;
        operacionModel.TOTAL_INTERESES = getTipoDeCalculoElegido().RESULTADOS.TOTAL_INTERESES;
        operacionModel.INTERES_PORCE = parametrosCalc.INTERES_PORCE;
        operacionModel.INTERES_IVA_PORCE = parametrosCalc.INTERES_IVA_PORCE;
        operacionModel.TOTAL_INTERESES_IVA = getTipoDeCalculoElegido().RESULTADOS.TOTAL_INTERESES_IVA;
        operacionModel.TOTAL_PRESTAMO = getTipoDeCalculoElegido().RESULTADOS.TOTAL_PRESTAMO;
        operacionModel.CUOTA_IMPORTE = getTipoDeCalculoElegido().RESULTADOS.CUOTA_IMPORTE;
        operacionModel.PRIMER_VENCIMIENTO = PRIMER_VENCIMIENTO;



        mostrar_resultados_calculo();

        ocultarMensajeDelSistema();
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





    /*** 
     * 
     * Cuotas
     */
    var cuotas_model = [];


    function mostrarCuotas() {
        let cellsStyles = ['form-control', 'form-control-sm'];



        /**Table constructor */
        let createTD = function(name, data, tipo) {
            let tipo__ = tipo == undefined ? "text" : tipo;
            let estilos = cellsStyles.join(" ");
            let domobj = "<input class='" + estilos + "'    type='" + tipo__ + "' readonly  value='" + data + "' >";

            return "<td>" + domobj + "</td>";
        };
        let createTR = function(obj) {

            let tds = Object.keys(obj).map((kname) => {
                if (kname == "VENCIMIENTO") return createTD(kname, obj[kname], "date");
                if (kname == "CUOTA") return createTD(kname, formatoNumerico.darFormatoEnMillares(obj[kname], 0), "text");
                if (kname == "IVA") return createTD(kname, formatoNumerico.darFormatoEnMillares(obj[kname], 0), "text");
                if (kname == "INTERES") return createTD(kname, formatoNumerico.darFormatoEnMillares(obj[kname], 0), "text");
                if (kname == "SALDO") return createTD(kname, formatoNumerico.darFormatoEnMillares(obj[kname], 0), "text");
                if (kname == "CAPITAL") return createTD(kname, formatoNumerico.darFormatoEnMillares(obj[kname], 0), "text");
                return createTD(kname, obj[kname]);
            }).join();
            return "<tr>" + tds + "</tr>";
        };
        $("#VENC-TABLE tbody").html("");

        let detalleGenCuota = getTipoDeCalculoElegido().DETALLE_CALCULO;
        cuotas_model = detalleGenCuota.map((cuo) => {
            return {
                NUMERO: cuo.IDCUOTA,
                VENCIMIENTO: cuo.VENCIMIENTO,
                DIA: cuo.DIA,
                INTERES: cuo.INTERES,
                IVA: cuo.IVA,
                CAPITAL: cuo.CAPITAL,
                MONTO: cuo.CUOTA,
                SALDO: cuo.SALDO
            };
        });

        detalleGenCuota.forEach(function(cuo) {
            $("#VENC-TABLE tbody").append(createTR(cuo));
        });

        //RECALCULAR TOTAL

      
        let total_intereses =  formatoNumerico.darFormatoEnMillares(   getTipoDeCalculoElegido().RESULTADOS.TOTAL_INTERESES, 0);
        let total_iva = formatoNumerico.darFormatoEnMillares(   getTipoDeCalculoElegido().RESULTADOS.TOTAL_INTERESES_IVA, 0);
        let total_amorti = formatoNumerico.darFormatoEnMillares(
            Math.round(detalleGenCuota.map(ar => ar.CAPITAL).reduce((acum, valor) => acum + valor, 0)), 0);
           
        let total_cuota = formatoNumerico.darFormatoEnMillares(
           detalleGenCuota.map(ar => ar.CUOTA).reduce((acum, valor) => Math.round(acum + valor), 0)   , 0);

        $("#CUOTAS-TABLE-TINTERES").text(total_intereses);
        $("#CUOTAS-TABLE-TIVA").text(total_iva);
        $("#CUOTAS-TABLE-TAMORTI").text(total_amorti);
        $("#CUOTAS-TABLE-TCUOTA").text(total_cuota);
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
        if ("mostrarCuotas" in window)
            mostrarCuotas();
    }
</script>