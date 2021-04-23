<?php

namespace App\Models;

use CodeIgniter\Model;

class  Ficha_inmuebles_model extends Model
{

    protected $table = 'ficha_inmuebles';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    protected $useTimestamps = false;
    /** */


    protected $allowedFields =
    [
        'NRO_CLIENTE', 'DESCRIPCION', 'VALOR', 'ESCRITURA', 'ACLARACION', 'NRO_FINCA', 'CTA_CATASTRAL' 
    ];


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
