<?php

namespace App\Models;

use CodeIgniter\Model;

class  Productos_finan_model extends Model
{

    protected $table = 'productos_finan';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    /** */

    protected $allowedFields =
    [
       'DESCRIPCION',  'INTERES_PORCE', 'GAST_ADM_PORCE', 'DIASXMES', 'DIASXANIO', 'MESESXANIO',
        'SEGURO_CANCEL',  'SEGURO_3ROS',  'MORA_PORCE', 'PUNITORIO_PORCE',  'CODIGO_PRODUCTO',
        'DIAS_SIN_INTERES'
    ];



    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
