<script>
    var sistemaFrances = {

        SALDO_CAPITAL: 0,
        IMPORTE_CUOTA: 0,
        NRO_CUOTAS: 0,
        INTERES_PORCE: 0.0,
        IVA_INTERES_PORCE: 0.0,
        DA: 0,
        MA: 0,
        DM: 0,

        INTERESs: [],
        IVAs: [],
        CAPITALs: [],
        SALDO_CAPITALs: [],
        DETALLE_CALCULO: [],

        init: function({
            DA,
            MA,
            DM,
            CAPITAL,
            NRO_CUOTAS,
            PORCEN_INTERES,
            PORCEN_IVA
        }) {

            this.DA = DA;
            this.MA = MA;
            this.DM = DM;
            this.SALDO_CAPITAL = CAPITAL;
            this.NRO_CUOTAS = NRO_CUOTAS;
            this.INTERES_PORCE = PORCEN_INTERES;
            this.IVA_INTERES_PORCE = PORCEN_IVA;
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
            let interes = CAPITAL_A_DESENVOL * (tasa * ma) * dm / da;
            return interes;
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
            let cuota = Math.round(numerador / denominador);
            return cuota;
        },




        generarCuotas() {


           
            let saldo_capital= this.SALDO_CAPITAL;
            let interes_porce= this.INTERES_PORCE;
            let nro_cuotas= this.NRO_CUOTAS ;
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
             
            
            let CuotaCounter= 1;
            let TotalCuotas= parseInt(  this.NRO_CUOTAS );
            while( CuotaCounter <= TotalCuotas ){

                this.INTERESs.push( interes_);
                //calcular iva 
                let iva_interes= (parseFloat(this.PORCEN_IVA))* parseInt(  interes_ );
                this.IVAs.push(  iva_interes );
                //calculo capital
                let capital_de_cuota= Math.abs( parseInt(cuota) -  parseInt( interes_ )) ;
                this.CAPITALs.push(  capital_de_cuota );
                //Adjuntar saldo actual
                this.SALDO_CAPITALs.push( this.SALDO_CAPITAL );
                //Nuevo saldo capital
                this.SALDO_CAPITAL= parseInt(  this.SALDO_CAPITAL ) - capital_de_cuota ;
                //recalcular interes
                interes_= this.calculaMontoInteresCuota( {CAPITAL_A_DESENVOL: this.SALDO_CAPITAL, TASA_INTERES: this.INTERES_PORCE } );

                CuotaCounter ++;
            }
        }
    };
</script>