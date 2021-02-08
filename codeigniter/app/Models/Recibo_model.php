<?php namespace App\Models;

use CodeIgniter\Model;

class  Recibo_model extends Model
{
    
    protected $table = 'recibo';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [  'IDNRO','created_at','IMPORTE','DEUDOR','IDCOBRO','CONCEPTO','FECHA_L'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}