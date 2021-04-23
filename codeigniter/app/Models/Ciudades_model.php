<?php namespace App\Models;

use CodeIgniter\Model;

class  Ciudades_model extends Model
{
    
    protected $table = 'ciudades';

    protected $primaryKey = 'REGNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'ciudad', 'departa'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}