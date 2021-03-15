<script>
    var sistemaFrances = {

        SALDO_CAPITAL: 0,
        IMPORTE_CUOTA: 0,
        NRO_CUOTAS: 0,
        INTERES_PORCE: 0.0,
        IVA_INTERES_PORCE: 0.0,
        PRIMER_VENCIMIENTO: null,
        FORMATO_GEN_VENCIMIENTO: "M",
        DIAS_DE_PAGO: null,
        DA: 0,
        MA: 0,
        DM: 0,

        INTERESs: [],
        IVAs: [],
        CAPITALs: [],
        SALDO_CAPITALs: [],
        VENCIMIENTOs: [],
        DETALLE_CALCULO: [],

        init: function({
            DA,
            MA,
            DM,
            CAPITAL,
            NRO_CUOTAS,
            PORCEN_INTERES,
            PORCEN_IVA,
            PRIMER_VENCIMIENTO,
            FORMATO,
            DIAS_PAGO
        }) {

            
            this.DA = DA;
            this.MA = MA;
            this.DM = DM;
            this.SALDO_CAPITAL = parseInt( CAPITAL );
            this.NRO_CUOTAS = NRO_CUOTAS;
            this.INTERES_PORCE = PORCEN_INTERES;
            this.IVA_INTERES_PORCE = PORCEN_IVA;
            this.PRIMER_VENCIMIENTO = PRIMER_VENCIMIENTO;
            this.FORMATO_GEN_VENCIMIENTO = FORMATO;
            this.DIAS_DE_PAGO = DIAS_PAGO;

        },
        calculaMontoInteresCuota: function({
            CAPITAL_A_DESENVOL,
            TASA_INTERES
        }) {

           
            let da = parseInt(this.DA);
            let ma = parseInt(this.MA);
            let dm = parseInt(this.DM);
            let tasa = parseFloat(TASA_INTERES);
           
            let capital = parseInt(CAPITAL_A_DESENVOL);
            let interes = capital * (tasa * ma) * dm / da;
           

            return Math.round(interes);
        },

        calculaMontoCuota: function({
            CAPITAL_A_DESENVOL,
            TASA_INTERES,
            NRO_CUOTAS
        }) {


            // (11900000 * ( (2.7591/100)* Math.pow( (2.7591/100) + 1, 12 )  )  )  /  ( Math.pow(2.7591/100 + 1,  12) -1  )

            let tasa = parseFloat(TASA_INTERES);
            let capital = parseInt(CAPITAL_A_DESENVOL);
            let nrocuotas = parseInt(NRO_CUOTAS);
            let numerador = (capital * (tasa * Math.pow((tasa + 1), nrocuotas)));
            let denominador = (Math.pow((1 + tasa), nrocuotas) - 1);
            let cuota = numerador / denominador;
            this.IMPORTE_CUOTA = cuota;
            return Math.round(cuota);
        },




        generarCuotas() {


            //LIMPIAR
            this.DETALLE_CALCULO = [];
            this.VENCIMIENTOs= [];
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
            this.VENCIMIENTOs = fechasDeVencimiento.map((ar) =>{ return { VENCIMIENTO: ar.VENCIMIENTO, DIA: ar.DIA};  });

            /**********End calculo fechas */


            let saldo_capital = this.SALDO_CAPITAL;
            let interes_porce = this.INTERES_PORCE;
            let nro_cuotas = this.NRO_CUOTAS;
            /**Importe constante de cuota */
            let cuota = this.calculaMontoCuota({
                CAPITAL_A_DESENVOL: saldo_capital,
                TASA_INTERES: interes_porce,
                NRO_CUOTAS: nro_cuotas
            });
            /**  Primer Interes cuota **  */
           

            let interes_ = this.calculaMontoInteresCuota({
                CAPITAL_A_DESENVOL: this.SALDO_CAPITAL,
                TASA_INTERES: this.INTERES_PORCE
            });
           

            let CuotaCounter = 1;
            let TotalCuotas = parseInt(this.NRO_CUOTAS);
            while (CuotaCounter <= TotalCuotas) {

                this.INTERESs.push(interes_);
                //calcular iva 
                let iva_interes = (parseFloat(this.IVA_INTERES_PORCE)/100) * parseInt(interes_);
              

                iva_interes= Math.round(  iva_interes );
                this.IVAs.push(iva_interes);
                //calculo capital
                let capital_de_cuota = Math.abs(parseInt(cuota) - parseInt(interes_));
                this.CAPITALs.push(capital_de_cuota);
               
                //Nuevo saldo capital
                this.SALDO_CAPITAL = parseInt(this.SALDO_CAPITAL) - capital_de_cuota;
               
                 //Adjuntar saldo actual
                 this.SALDO_CAPITALs.push(this.SALDO_CAPITAL);
                //recalcular interes
                interes_ = this.calculaMontoInteresCuota({
                    CAPITAL_A_DESENVOL: this.SALDO_CAPITAL,
                    TASA_INTERES: this.INTERES_PORCE
                });

                CuotaCounter++;
            }

            //Juntar resultados
            //NRO CUOTA  - VENCIMIENTO - INTERES - IVA - CAPITAL - IMPORTECUOTA - SALDOCAPITAL
            for (let nc = 0; nc < TotalCuotas; nc++) {
                let idcuota = (nc + 1);
                let vencimi = this.VENCIMIENTOs[nc]["VENCIMIENTO"];
                let dia_venci= this.VENCIMIENTOs[nc]["DIA"];
                let intere = this.INTERESs[nc];
                let ivaInte = this.IVAs[nc];
                let capital = this.CAPITALs[nc];
                let saldocap = this.SALDO_CAPITALs[nc];
                let data = {
                    IDCUOTA: idcuota,
                    VENCIMIENTO: vencimi,
                    DIA: dia_venci,
                    INTERES: intere,
                    IVA: ivaInte,
                    CAPITAL: capital,
                    CUOTA: this.IMPORTE_CUOTA,
                    SALDO: saldocap
                };
                this.DETALLE_CALCULO.push(data);

            } /**End for */
        }

    };
</script>