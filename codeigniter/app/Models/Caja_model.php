<?php namespace App\Models;

use CodeIgniter\Model;

class  Caja_model extends Model
{
    
    protected $table = 'caja';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'NOMBRE', 'ESTADO'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}