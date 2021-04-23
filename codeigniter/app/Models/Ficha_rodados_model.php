<?php

namespace App\Models;

use CodeIgniter\Model;

class  Ficha_rodados_model extends Model
{

    protected $table = 'ficha_rodados';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    protected $useTimestamps = false;
    /** */


    protected $allowedFields =
    [
        'NRO_CLIENTE', 'MARCA', 'MODELO', 'CHAPA'
    ];


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
