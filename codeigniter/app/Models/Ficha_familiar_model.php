<?php

namespace App\Models;

use CodeIgniter\Model;

class  Ficha_familiar_model extends Model
{

    protected $table = 'ficha_familiar';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    protected $useTimestamps = false;
    /** */


    protected $allowedFields =
    [
        'NRO_CLIENTE', 'CEDULA', 'NOMBRE', 'TELEFONO', 'DOMICILIO', 'EMPLEO', 'RELACION', 'EMPRESA',
        'DOMICI_LABO'
    ];


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
