<?php namespace App\Models;

use CodeIgniter\Model;

class  Documentos_model extends Model
{
    
    protected $table = 'documentos';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [  'DESCR', 'UBICACION'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}