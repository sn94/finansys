<script>
    function deepClone(obj) {

        var clone = {};

        //Esta vacio?
        //if( Object.keys(  obj).length  == 0  )
        //clone[]
        for (var key_ in obj) {


            var valor = obj[key_];
            if (typeof valor != "object")
                clone[key_] = valor;
            else {
                if (Array.isArray(valor))
                    clone[key_] = valor.slice();
                else
                    clone[key_] = deepClone(valor);
            }
        }
        return clone;
    }



    var sistemaDeCalculoInterface = {

        MONTO_CREDITO: 0,
        NRO_CUOTAS: 0,
        PRIMER_VENCIMIENTO: '',

        GAST_ADM_PORCE: 0,
        INTERES_PORCE: 0,
        INTERES_IVA_PORCE: 0,


        SEGURO_CANCEL: 0,
        /**Cuanto por millon */
        SEGURO_3ROS: 0,
        DIASXMES: 0,
        MESESXANIO: 0,
        DIASXANIO: 0,
        //Generacion de fechas de vencimiento
        FORMATO_GEN_VENCIMIENTO: "M", //Formato
        DIAS_DE_PAGO: [1, 2, 3, 4, 5, 6],

        RESULTADOS: {
            CUOTA_IMPORTE: 0,
            SEGURO_CANCEL: 0,
            SEGURO_3ROS: 0,
            GASTOS_ADM: 0,
            TOTAL_INTERESES: 0,
            TOTAL_INTERESES_IVA: 0,
            CAPITAL_DESEMBOLSO: 0,
            TOTAL_PRESTAMO: 0
        },

        /**Funciones */

        setUserInputs: function(userin) {

            Object.assign(this, userin);
        },
        setParametros: function(params) {

            Object.assign(this, params);
        },
        calcularCapitalNetoDesembolsar: function() {
            let monto_ = parseInt(this.MONTO_CREDITO);
            let seguro_cancel = (parseInt(this.SEGURO_CANCEL)) * (monto_ / 1000000);
            let seguro_3ros = (parseInt(this.SEGURO_3ROS)) * (monto_ / 1000000);
            let gastos_adm = (parseFloat(this.GAST_ADM_PORCE) / 100) * monto_;
            let capital_neto_a_desem = monto_ + seguro_cancel + seguro_3ros + gastos_adm;



            //calcular interes total
            let NRO_CUOTAS = parseInt(this.NRO_CUOTAS);
            let INTERES_PORCE = parseFloat(this.INTERES_PORCE) / 100; // / 100; //8 dec
            console.log("Intereses", monto_, INTERES_PORCE, NRO_CUOTAS);

            let intereses = (monto_ * (INTERES_PORCE)) * NRO_CUOTAS;
            intereses = isNaN(intereses) ? 0 : intereses;
            console.log("Calculado interes", intereses);

            let intereses_iva_porce = parseFloat(this.INTERES_IVA_PORCE) / 100;
            let iva_intereses = intereses * (intereses_iva_porce);
            iva_intereses = isNaN(iva_intereses) ? 0 : iva_intereses;

            let total_prestamo = capital_neto_a_desem + intereses + iva_intereses;


            this.RESULTADOS.SEGURO_CANCEL = isNaN(seguro_cancel) ? 0 : seguro_cancel;
            this.RESULTADOS.SEGURO_3ROS = isNaN(seguro_3ros) ? 0 : seguro_3ros;
            this.RESULTADOS.GASTOS_ADM = isNaN(gastos_adm) ? 0 : gastos_adm;
            this.RESULTADOS.CAPITAL_DESEMBOLSO = isNaN(capital_neto_a_desem) ? 0 : capital_neto_a_desem;
            this.RESULTADOS.TOTAL_INTERESES = isNaN(intereses) ? 0 : intereses;
            this.RESULTADOS.TOTAL_INTERESES_IVA = isNaN(iva_intereses) ? 0 : iva_intereses;
            this.RESULTADOS.TOTAL_PRESTAMO = isNaN(total_prestamo) ? 0 : total_prestamo;

        },
        calcularMontoInteresCuota: function(capital_neto_a_desem) {

            let da = parseInt(this.DIASXANIO);
            let ma = parseInt(this.MESESXANIO);
            let dm = parseInt(this.DIASXMES);
            let tasa = parseFloat(this.INTERES_PORCE) / 100;

            let capital = parseInt(capital_neto_a_desem == undefined ? this.RESULTADOS.CAPITAL_DESEMBOLSO : capital_neto_a_desem);
            let interes = capital * (tasa * ma) * dm / da;
            return Math.round(interes);
        },

        generarCuotas() {   


            //LIMPIAR
            this.DETALLE_CALCULO = [];
            this.VENCIMIENTOs = [];
            /**
             * 
             * *Fechas de vencimiento
             * *** 
             * **
             */
            let calculoFechas = calcVencimientos;
            //fecha de ref  formato gen cuo  nrocuota   diasdepago   
            calculoFechas.init({
                PRIMER_VENCIMIENTO: this.PRIMER_VENCIMIENTO,
                FORMATO: this.FORMATO_GEN_VENCIMIENTO,
                NRO_CUOTAS: this.NRO_CUOTAS,
                DIAS_PAGO: this.DIAS_DE_PAGO
            });
            let fechasDeVencimiento = calculoFechas.generarCuotas();
            this.VENCIMIENTOs = fechasDeVencimiento.map((ar) => {
                return {
                    VENCIMIENTO: ar.VENCIMIENTO,
                    DIA: ar.DIA
                };
            });

            /**********End calculo fechas */

            /**Importe constante de cuota */
            let cuota = this.RESULTADOS.CUOTA_IMPORTE;

            /**  Primer Interes cuota **  */
            let interes_ = this.calcularMontoInteresCuota(this.RESULTADOS.CAPITAL_DESEMBOLSO);

            /**Saldo capital =  capital_neto_desem - ( capital + interes IVA ) */
            let SALDO_CAPITAL_ACUM = this.RESULTADOS.CAPITAL_DESEMBOLSO;

            let CuotaCounter = 1;
            let TotalCuotas = parseInt(this.NRO_CUOTAS);
            while (CuotaCounter <= TotalCuotas) {

                //calcular iva 
                let iva_interes = (parseFloat(this.INTERES_IVA_PORCE) / 100) * parseInt(interes_);
                iva_interes = Math.round(iva_interes);
                //calculo capital
                let capital_de_cuota = Math.abs(parseInt(cuota) - parseInt(interes_));
                //Nuevo saldo capital
                SALDO_CAPITAL_ACUM = SALDO_CAPITAL_ACUM - (capital_de_cuota + iva_interes); //parseInt(this.SALDO_CAPITAL) - cuota; //mENOS EL MONTO DE CUOTA


                this.INTERESs.push(interes_);
                this.IVAs.push(iva_interes);
                this.CAPITALs.push(capital_de_cuota);
                this.SALDOS_CAPITALES.push(SALDO_CAPITAL_ACUM);

                //recalcular interes
                interes_ = this.calcularMontoInteresCuota(SALDO_CAPITAL_ACUM);
                CuotaCounter++;
            }

            //Juntar resultados
            //NRO CUOTA  - VENCIMIENTO - INTERES - IVA - CAPITAL - IMPORTECUOTA - SALDOCAPITAL
            for (let nc = 0; nc < TotalCuotas; nc++) {
                let idcuota = (nc + 1);
                let vencimi = this.VENCIMIENTOs[nc]["VENCIMIENTO"];
                let dia_venci = this.VENCIMIENTOs[nc]["DIA"];
                let intere = this.INTERESs[nc];
                let ivaInte = this.IVAs[nc];
                let capital = this.CAPITALs[nc];
                let saldocap = this.SALDOS_CAPITALES[nc];

                let data = {
                    IDCUOTA: idcuota,
                    VENCIMIENTO: vencimi,
                    DIA: dia_venci,
                    INTERES: intere,
                    IVA: ivaInte,
                    CAPITAL: capital,
                    CUOTA: this.RESULTADOS.CUOTA_IMPORTE,
                    SALDO: saldocap
                };
                this.DETALLE_CALCULO.push(data);

            } /**End for */
        },
        calcularMontoCuota: undefined
    };





    /*************** 
     *  ****  ****   *   **   *   **** *****   ***
     *  *     *  *  * *  * *  *  *     *      *   
     *  ***** **** ***** *  * *  *     *****   ****
     *  *     *  * *   * *   **  *     *           *  
     *  *     *  * *   * *    *   **** *****  *****
     * */
    var sistemaFrances = deepClone(sistemaDeCalculoInterface);

    //Implementar
    sistemaFrancesDerivado = {


        /** Resultado */
        INTERESs: [],
        IVAs: [],
        CAPITALs: [],
        SALDOS_CAPITALES: [],
        VENCIMIENTOs: [],
        DETALLE_CALCULO: [],


        init: function() {
            this.calcularCapitalNetoDesembolsar();
            this.calcularMontoCuota();
            this.generarCuotas();
        },




        calcularMontoCuota: function() {
            // (11900000 * ( (2.7591/100)* Math.pow( (2.7591/100) + 1, 12 )  )  )  /  ( Math.pow(2.7591/100 + 1,  12) -1  )

            let tasa = parseFloat(this.INTERES_PORCE) / 100;
            let capital = parseInt(this.RESULTADOS.CAPITAL_DESEMBOLSO);
            let nrocuotas = parseInt(this.NRO_CUOTAS);
            let numerador = (capital * (tasa * Math.pow((tasa + 1), nrocuotas)));
            let denominador = (Math.pow((1 + tasa), nrocuotas) - 1);
            let importe_de_la_cuota = numerador / denominador;
            importe_de_la_cuota = Math.round(importe_de_la_cuota);
            importe_de_la_cuota = (!isFinite(importe_de_la_cuota) || isNaN(importe_de_la_cuota)) ? 0 : importe_de_la_cuota;

            this.RESULTADOS.CUOTA_IMPORTE = importe_de_la_cuota;
            return importe_de_la_cuota;
        }

    };

    Object.assign(sistemaFrances, sistemaFrancesDerivado);





    /** **      ***      *********     ***     ***       ***      ***    **
      ******    ***      ***          ****     ****     *    *    ****   **
     **    **   ***      *********    **  *   *  **    ********   *** *  **
     ********   ***      *********    **   ***   **   **      **  ***  ** *
     **     **  ******** ***          **         **   **      **  ***   ***
    ***     *** ******** *********    **         **   **      **  ***   ***
     */

    var sistemaAleman = deepClone(sistemaDeCalculoInterface);

//Implementar
sistemaAlemanDerivado = {


    /** Resultado */
    INTERESs: [],
    IVAs: [],
    CAPITALs: [],
    SALDOS_CAPITALES: [],
    VENCIMIENTOs: [],
    DETALLE_CALCULO: [],


    init: function() {
        this.calcularCapitalNetoDesembolsar();
        this.calcularMontoCuota();
        this.generarCuotas();
    },




    calcularMontoCuota: function() {
        //  

        let tasa = parseFloat(this.INTERES_PORCE) / 100;

        let capital = parseInt(this.RESULTADOS.CAPITAL_DESEMBOLSO);

        let nrocuotas = parseInt(this.NRO_CUOTAS);

        let numerador = (capital * tasa); //capital * interes %
        let denominador =  1-  (  Math.pow(   (1 - tasa)  , nrocuotas) );  // 1- (1 - interes%) ^ nrocuotas
        let importe_de_la_cuota = numerador / denominador;

        importe_de_la_cuota = Math.round(importe_de_la_cuota);
        importe_de_la_cuota = (!isFinite(importe_de_la_cuota) || isNaN(importe_de_la_cuota)) ? 0 : importe_de_la_cuota;

        this.RESULTADOS.CUOTA_IMPORTE = importe_de_la_cuota;
        return importe_de_la_cuota;
    }

};

Object.assign(sistemaAleman, sistemaAlemanDerivado);







var SISTEMA_DE_AMORTIZACION=  {
    'FRANCES' :  sistemaFrances,
    'ALEMAN' : sistemaAleman
};

</script>