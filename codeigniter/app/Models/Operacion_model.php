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
        //DURANTE EL REGISTRO
        'NRO_CLIENTE' ,  'EMPRESA', 'CREDITO', 'PRIMER_VENCIMIENTO', 'INTERES', 'INTERES_FINAL' ,
        'CUOTAS','CUOTA_IMPORTE', 'INTERES_CUOTA',  'SEGURO', 'GASTOS_ADM', 'ESTADO',

        //PARA GENERAR LOS VENCIMIENTOS
        //IGNORAR POR AHORA
        'PORCENTAJE_CAPITAL', 'PORCENTAJE_INTERES', 'INTERES_FINAL',  'LETRA', 'CORRELATIVO', 'FACTURA', 'PROMEDIO'
    ];



    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
