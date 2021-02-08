<?php namespace App\Models;

use App\Helpers\Utilidades;
use CodeIgniter\Model;

class  Cat_monto_model extends Model
{
    
    protected $table = 'categoria_monto';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'MONTO','NRO_CUOTAS','CUOTA','INT_PORCE',  'FORMATO'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }




    public function list_dropdown(){
        		/***Montos */
		$db = \Config\Database::connect();
		$reg= $db->query("select IDNRO, CONCAT(MONTO, CONCAT(' Gs. = ', concat(CUOTA,CONCAT(' X ', CONCAT(NRO_CUOTAS, ( CASE WHEN FORMATO='D' THEN ' (Diario)' WHEN FORMATO='S' THEN ' (Semanal)'  WHEN FORMATO='Q' THEN ' (Quincenal)' WHEN FORMATO='M' THEN ' (Mensual)' END) ) ) ) ) ) AS DESCR from categoria_monto"); 
		$montos_d=$reg->getResultArray();
        $montos=  Utilidades::dropdown($montos_d);
        return $montos;
		/**** */
    }

}