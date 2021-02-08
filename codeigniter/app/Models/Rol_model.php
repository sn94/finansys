<?php namespace App\Models;

use CodeIgniter\Model;

class  Rol_model extends Model
{
    
    protected $table = 'rol';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [  'DESCR'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}