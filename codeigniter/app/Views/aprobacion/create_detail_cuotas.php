<style>
    #VENC-TABLE tbody tr td,
    #VENC-TABLE tbody tr th {
        padding: 0px;
        margin-right: 0px;
    }

    #VENC-TABLE tr th,
    #VENC-TABLE tbody tr td input {
        text-align: right !important;
    }

    #VENC-TABLE tbody tr td input {
        border-color: transparent;
    }

    #VENC-TABLE tr th:nth-child(1),
    #VENC-TABLE tbody tr>td:nth-child(1) {
        width: 50px;
    }

    #VENC-TABLE tr th:nth-child(2),
    #VENC-TABLE tbody tr>td:nth-child(2) {
        width: 120px;
    }

    #VENC-TABLE tr th:nth-child(3),
    #VENC-TABLE tbody tr>td:nth-child(3) {
        width: 100px;
    }

    #VENC-TABLE tr th:nth-child(4),
    #VENC-TABLE tbody tr>td:nth-child(4) {
        width: 100px;
    }

    #VENC-TABLE tr th:nth-child(5),
    #VENC-TABLE tbody tr>td:nth-child(5) {
        width: 100px;
    }

    #VENC-TABLE tr th:nth-child(6),
    #VENC-TABLE tbody tr>td:nth-child(6) {
        width: 100px;
    }

    #VENC-TABLE tr th:nth-child(7),
    #VENC-TABLE tbody tr>td:nth-child(7) {
        width: 100px;
    }

    #VENC-TABLE tr th:nth-child(8),
    #VENC-TABLE tbody tr>td:nth-child(8) {
        width: 100px;
    }
</style>

<div class="row mr-md-5 ml-md-5 ">

    <button type="button" onclick="mostrarCuotas()" class="btn btn-sm btn-info">Generar cuotas</button>
    <table class="table table-hover table-sm " id="VENC-TABLE">
        <thead>
            <tr>
                <th>N°</th>
                <th>VENCIMIENTO</th>
                <th>DIA</th>
                <th>INTERÉS</th>
                <th>IVA</th>
                <th>CAPITAL</th>
                <th>CUOTA</th>
                <th>SALDO CAPITAL</th>
            </tr>
        </thead>
        <tbody id="CUOTAS-TABLE">

        </tbody>
    </table>
</div>


<script>
    var cellsStyles = ['form-control', 'form-control-sm'];

    var cuotas_model = [];

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

   

    async function mostrarCuotas() {
        $("#VENC-TABLE tbody").html("");
        //cuota vencimiento dia
        await iniciar_calculos_de_operacion();
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

    }
</script>