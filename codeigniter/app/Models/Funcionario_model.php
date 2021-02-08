<?php namespace App\Models;

use CodeIgniter\Model;

class  Funcionario_model extends Model
{
    
    protected $table = 'funcionario';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'CEDULA','NOMBRES','APELLIDOS','DOMICILIO','TELEFONO','CELULAR','CARGO','HORARIO','DIAS_LABO','CIUDAD','FOTO','created_at','updated_at'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}