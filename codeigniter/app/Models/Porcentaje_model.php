<?php namespace App\Models;

use App\Helpers\Utilidades;
use CodeIgniter\Model;

class  Porcentaje_model extends Model
{
    
    protected $table = 'porcentaje';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [  'PORCENTAJE'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }


    
    public function list_dropdown()
    { 
        $db = \Config\Database::connect();
        $reg = $db->query("select IDNRO,    PORCENTAJE  from porcentaje");
        $empre = $reg->getResultArray();
        $montos =  Utilidades::dropdown($empre);
        return $montos;
        /**** */
    }



}