<?php

namespace App\Models;

use CodeIgniter\Model;

class  Cobro_model extends Model
{

    protected $table = 'cobro';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    /** */

    protected $allowedFields =
    [
        'FECHA', 'CAJERO', 'DEUDOR', 'CAJA', 'EFECTIVO_T', 'ESTADO', 'IDOPERACION',
        'CHEQUE_IMPO', 'CHEQUE_NRO', 'CHEQUE_BANC', 'TARJE_IMPO', 'TARJE_TIPO', 'TARJE_VOUCH', 'OBS',

        'MORA', 'IVA_MORA', 'PUNITORIO', 'IVA_PUNITORIO', 'TOTAL_ABSOLUTO'
    ];



    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
    }
}
