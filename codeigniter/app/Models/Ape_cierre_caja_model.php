<?php namespace App\Models;

use CodeIgniter\Model;

class  Ape_cierre_caja_model extends Model
{
    
    protected $table = 'ape_cierre_caja';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'CAJA','CAJERO','SALDO_INI','APERTURA','CIERRE','T_EFECTIVO','T_CHEQUE','T_TARJETA','SOBRANTE','FALTANTE'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}