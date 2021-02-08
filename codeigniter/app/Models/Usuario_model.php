<?php namespace App\Models;

use CodeIgniter\Model;

class  Usuario_model extends Model
{
    
    protected $table = 'usuario';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [  'FUNCIONARIO',  'NICK','PASS','ROL','ESTADO'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}