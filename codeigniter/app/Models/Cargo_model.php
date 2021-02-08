<?php namespace App\Models;

use CodeIgniter\Model;

class  Cargo_model extends Model
{
    
    protected $table = 'cargo';

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