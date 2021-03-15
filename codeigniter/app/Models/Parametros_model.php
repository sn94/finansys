<?php

namespace App\Models;

use CodeIgniter\Model;

class  Parametros_model extends Model
{

    protected $table = 'parametros';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    /** */

    protected $allowedFields =
    [
        'BCP_INTERES', 'SALARIO_MIN', 'JORNAL_MIN', 'GAST_ADM_PORCE', 'DIASXMES', 'DIASXANIO', 'IVA', 'MESESXANIO',
        'SEGURO_CANCEL',  'SEGURO_3ROS',  'MORA_PORCE', 'PUNITORIO_PORCE'
    ];



    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
