<script>
    var calcVencimientos = {

        fechaReferencia: null,
        formatoGenCuotas: "M",
        /* D S M Q */
        numeroDeCuotas: 0,
        diasDePago: null,
        /** 1 2 3 4 5 6 7 */
        init: function({
            PRIMER_VENCIMIENTO,
            FORMATO,
            NRO_CUOTAS,
            DIAS_PAGO
        }) {

            this.fechaReferencia = PRIMER_VENCIMIENTO;
            this.formatoGenCuotas = FORMATO;
            this.numeroDeCuotas = NRO_CUOTAS;
            /*this.montoDeCredito= montoDeCredito;
           
            this.montoDeCuota= montoDeCuota;*/
            this.diasDePago = DIAS_PAGO;
        },

        calcularCuota: function() {

            //formula sistema frances
            this.montoDeCuota = 0;
        },
        formatoCuotas: function(key) {
            let evaluado = (key == undefined) ? (this.formatoGenCuotas == "" ? "M" : this.formatoGenCuotas) : key;
            let num = 1;
            switch (evaluado) {
                case "D":
                    num = 1;
                    break; // Para Sumar un dia para generar la siguiente fecha de vencimiento
                case "S":
                    num = 7;
                    break; //Para Sumar 7dias
                case "Q":
                    num = 15;
                    break; // Para Sumar 15 dias
                case "M":
                    num = 30;
                    break; // Para Sumar 30 dias
            }
            return num;
        },
        es_bisiesto: function(nu) {
            if (parseInt(nu) % 4 == 0) {
                if (parseInt(nu) % 100 == 0) {
                    if (parseInt(nu) % 400 == 0) {
                        return true;
                    } else return false;
                } else {
                    return true;
                }
            } else return false;
        },
        obtenerNombreDia: function(dia) {
            let dia_semana = "DOMINGO";
            switch (dia) {
                case 0:
                    dia_semana = "DOMINGO";
                    break;
                case 1:
                    dia_semana = "LUNES";
                    break;
                case 2:
                    dia_semana = "MARTES";
                    break;
                case 3:
                    dia_semana = "MIERCOLES";
                    break;
                case 4:
                    dia_semana = "JUEVES";
                    break;
                case 5:
                    dia_semana = "VIERNES";
                    break;
                case 6:
                    dia_semana = "SABADO";
                    break;
            }
            return dia_semana;
        },
        obtenerDiasDePago: function() {

            //Por defecto tomar el dia de fecha de inicio de vencimiento
            let return_default_day = function(esto) {
                let fecha_ini = esto.fechaReferencia;

                let dma = fecha_ini.split("-");
                let dia_ = new Date(dma[0], dma[1], dma[2]).getDay();
                return [dia_];
            };

            if (this.diasDePago == null) return return_default_day(this);
            else return this.diasDePago;
        },

        generarCuotas: function() {

            let contextoThis = this;
            let fechasDeVencimiento = [];
            //Asegurar fecha cargada
            if (this.fechaReferencia == null) {
                alert("INDICAR FECHA DE INICIO DE COBRO PARA GENERAR LAS CUOTAS");
                return [];
            }
            //Asegurar dias de pago marcados
            if (this.obtenerDiasDePago().length <= 0) {
                alert("MARQUE AL MENOS UN DIA PARA LOS PAGOS");
                return [];
            }

            let fecha_inicio = this.fechaReferencia;
            /* let montobase = this.montoDeCredito;
             let nrocuotas = this.numeroDeCuotas;
             let cuotas = this.montoDeCuota;*/

            //convertir a fecha
            let partes_fecha_base = fecha_inicio.split("-").map(function(ar) {
                return parseInt(ar);
            });

            let fechaBase = new Date(partes_fecha_base[0], partes_fecha_base[1] - 1, partes_fecha_base[2]);
            let DIA_BASE = fechaBase.getDate();

            let dia = 1;

            while (dia <= this.numeroDeCuotas) {

                //Obtener dia mes anio 
                let anio = fechaBase.getFullYear();
                let mes = (fechaBase.getMonth() + 1) < 10 ? "0" + (fechaBase.getMonth() + 1) : (fechaBase.getMonth() + 1);
                let diaa = (fechaBase.getDate()) < 10 ? "0" + (fechaBase.getDate()) : (fechaBase.getDate());
                let vencimiento = anio + "-" + mes + "-" + diaa;
                let formato = contextoThis.formatoCuotas();


                // let showvencimiento = "<input readonly type='date' name='DETALLE_VENCIMIENTO[]' value='" + vencimiento + "' >";
                //let showcuotas = "<input readonly type='hidden' name='DETALLE_MONTO[]' value='" + cuotas + "' >";

                //Dia de la semana en que cae el vencimiento
                let numeroDia = fechaBase.getDay(); // 1 2 3 4 5 6
                //Es uno de los dias marcados para PAGO ?
                let diasPermitidos = contextoThis.obtenerDiasDePago();

                if (diasPermitidos.includes(numeroDia)) {

                    let dia_semana = contextoThis.obtenerNombreDia(numeroDia); //Lunes, Martes, miercoles,etc ...
                    fechasDeVencimiento.push({
                        NUMERO: dia,
                        VENCIMIENTO: vencimiento,
                        DIA: dia_semana
                    });
                    //OPCION 1    -----  Mantener dia constante 
                    let NUEVA_FECHA_DIA= true ? DIA_BASE :  fechaBase.getDate();
                    let nuevaFechaBase = new Date(fechaBase.getFullYear(), fechaBase.getMonth() + 1, NUEVA_FECHA_DIA);
                    fechaBase = nuevaFechaBase;
                    
                    //OPCION 2    ------ Incrementar fecha en X dias
                    // fechaBase.setDate(fechaBase.getDate() + formato); //La siguiente fecha de vencimiento

                    dia++; // Seguir calculando pero para la siguiente cuota

                } else {
                    //mantener el contador pero seguir 
                    //Incrementando fecha hasta llegar a uno de los dias permitidos
                    fechaBase.setDate(fechaBase.getDate() + 1);
                    let dia_permi = fechaBase.getDay();
                    while (!(diasPermitidos.includes(dia_permi))) {
                        fechaBase.setDate(fechaBase.getDate() + 1);
                        dia_permi = fechaBase.getDay();
                    } 

                }
            }
            return fechasDeVencimiento;
        }



    };

 
</script>