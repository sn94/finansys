<style>
    #VENC-TABLE tbody tr td,
    #VENC-TABLE thead tr th {
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
    <table class="table table-hover table-sm table-info table-striped " id="VENC-TABLE">
        <thead>
            <tr>
                <th>N°</th>
                <th>VENCIMIENTO</th>
                <th>DIA</th>
                <th>INTERÉS</th>
                <th>IVA</th>
                <th>AMORTIZ.</th>
                <th>CUOTA</th>
                <th>SALDO CAPITAL</th>
            </tr>
        </thead>
        <tbody id="CUOTAS-TABLE">

        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td id="CUOTAS-TABLE-TINTERES" class="text-right"></td>
                <td id="CUOTAS-TABLE-TIVA"  class="text-right"></td>
                <td id="CUOTAS-TABLE-TAMORTI"  class="text-right"></td>
                <td id="CUOTAS-TABLE-TCUOTA"  class="text-right"></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>