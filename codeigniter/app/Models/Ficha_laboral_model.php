<?php

namespace App\Models;

use CodeIgniter\Model;

class  Ficha_laboral_model extends Model
{

    protected $table = 'ficha_laboral';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    protected $useTimestamps = false;
    /** */


    protected $allowedFields =
    [
        'NRO_CLIENTE', 'DESCRIPCION', 'TELEFONO', 'DOMICILIO', 'CARGO', 'SUELDO', 'HORARIO_LABO', 'DEPARTAMENTO',
        'TIPO_EMPRESA', 'ANTIGUEDAD_ANIOS', 'ANTIGUEDAD_MESES'
    ];


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
