<?php namespace App\Models;

use CodeIgniter\Model;

class  Detalle_cobro_model extends Model
{
    
    protected $table = 'detalle_cobro';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'IDCOBRO','IDCUOTA','IMPORTE'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}