<?php namespace App\Models;

use CodeIgniter\Model;

class  Garante_model extends Model
{
    
    protected $table = 'garante';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'CEDULA' , 'FECHA_NAC','NOMBRES','APELLIDOS','DOMICILIO','TELEFONO','CELULAR','CIUDAD','CEDU_ANVERSO','CEDU_REVERSO',
    'OCUPACION','DOMICILIO_LABO','TELEFONO_LABO', 'CEDULA_CONYU','CONYUGE','created_at','updated_at'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }



}