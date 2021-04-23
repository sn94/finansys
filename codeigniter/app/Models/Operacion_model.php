<?php

namespace App\Models;

use CodeIgniter\Model;

class  Operacion_model extends Model
{

    protected $table = 'operacion';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    protected $useTimestamps = true;
    /** */

    protected $allowedFields =
    [
        //Principales
        'NRO_CLIENTE', 'PRODUCTO_FINA', 'SISTEMA',  'EMPRESA',
        'PRIMER_VENCIMIENTO', 'CREDITO',  'NRO_CUOTAS',

        //Calculados
        'CUOTA_IMPORTE',
        'SEGURO_CANCEL',
        'SEGURO_3ROS',
        'GASTOS_ADM',
        'TOTAL_INTERESES',
        'TOTAL_INTERESES_IVA',
        'CAPITAL_DESEMBOLSO',
        'TOTAL_PRESTAMO',
        //Parametros
        'INTERES_PORCE',
        'INTERES_IVA_PORCE',

        'ESTADO', 'LETRA', 'CORRELATIVO', 'FACTURA',
        'GARANTE1_CI', 'GARANTE1_NOM', 'GARANTE2_CI', 'GARANTE2_NOM', 'GARANTE3_CI', 'GARANTE3_NOM',
        'FUNCIONARIO',  'PROCESADO_POR',


        //Nuevos
        'MONTO_SOLICI', 'FECHA_SOLICITUD',
        'TIPO_MORA', 'TIPO_CREDITO', 'OFICIAL_CREDITO', 
        'FECHA_APROBACION', 'APROBADO_POR', 'MONTO_ENTREGADO',


    ];



    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
