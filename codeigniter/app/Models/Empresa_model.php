<?php

namespace App\Models;

use App\Helpers\Utilidades;
use CodeIgniter\Model;

class  Empresa_model extends Model
{

    protected $table = 'empresa';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    /** */

    protected $allowedFields =
    ['DESCR'];



    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }





    public function list_dropdown()
    {
        /***Montos */
        $db = \Config\Database::connect();
        $reg = $db->query("select IDNRO,    DESCR  from empresa");
        $empre = $reg->getResultArray();
        $montos =  Utilidades::dropdown($empre);
        return $montos;
        /**** */
    }
}
