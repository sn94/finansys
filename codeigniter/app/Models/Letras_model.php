<?php

namespace App\Models;

use App\Helpers\Utilidades;
use CodeIgniter\Model;

class  Letras_model extends Model
{

    protected $table = 'letras';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    /** */

    protected $allowedFields =
    ['LETRA', 'ULT_NUMERO'];


    protected $useTimestamps = true;


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }



    public function list_dropdown()
    {
        $db = \Config\Database::connect();
        $reg = $db->query("select IDNRO,  CONCAT(LETRA,CONCAT('-', ULT_NUMERO))  from letras");
        $empre = $reg->getResultArray();
        $montos =  Utilidades::dropdown($empre);
        return $montos;
        /**** */
    }
}
