<?php namespace App\Models;

use CodeIgniter\Model;

class  Permisos_model extends Model
{
    
    protected $table = 'permisos';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'PERMISO', 'RECURSO'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}