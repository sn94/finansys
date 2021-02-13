<?php

namespace App\Models;

use CodeIgniter\Model;

class  Deudor_model extends Model
{

    protected $table = 'deudor';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';
    protected $useTimestamps = true;
    /** */

    
    protected $allowedFields =
    [
        'CEDULA', 'RUC', 'NOMBRES', 'APELLIDOS', 'DOMICILIO', 'TELEFONO', 'CELULAR', 'CIUDAD', 'CEDU_ANVERSO',
        'CEDU_REVERSO', 'FECHA_NAC',

       
        'CEDULA_CONYU', 'CONYUGE', 'CONYUGE_OCUPACION', 'CONYUGE_ANTIGUEDAD', 'CONYUGE_EMPRESA', 'CONYUGE_TEL_TRABAJO',
        'CONYUGE_DIR_TRABAJO', 'CONYUGE_CARGO_TRABAJO', 'CONYUGE_UNIDAD_TRABAJO',


        'FAMILIAR1', 'FAMILIAR1_TELEF', 'FAMILIAR1_EMPLEO',
        'FAMILIAR2', 'FAMILIAR2_TELEF', 'FAMILIAR2_EMPLEO',
        'FAMILIAR3', 'FAMILIAR3_TELEF', 'FAMILIAR3_EMPLEO',

        'BARRIO', 'EMAIL', 'SEXO', 'ESTADO_CIVIL',  'HORARIO_LABO', 'CONYUGE_TELEF', 'CONYUGE_SUELDO',

        'OCUPACION', 'DOMICILIO_LABO', 'TELEFONO_LABO', 'TIPO_INSTI_TRABAJO', 'ANTIGUEDAD_ANIOS', 'ANTIGUEDAD_MESES',
         'CARGO', 'DEPARTAMENTO', 'SUELDO', 'INGRESOS1',  'INGRESOS2',  'TRABAJO1','TRABAJO2','TRABAJO2_DIR', 'TRABAJO2_TELEF',

        'INMUEBLE', 'INMUEBLE_VALOR', 'INMUEBLE_ESCRITURA', 'NRO_FINCA', 'CTA_CATASTRAL', 'AUTO_MARCA', 'AUTO_MODELO', 'AUTO_CHAPA',


        'ALQUILER_IMPORTE', 'ALQUILER_PROPIE', 'ALQUILER_TEL', 'ALQUILER_DESDE', 'TIPO_VIVIENDA',

        'REFEREN_OBT', 'OTRAS_REFEREN', 'CTAS_ACTIVAS', 'CTAS_CANCELADAS', 'ANTECEDENTES',

//NUEVOS
        'ANALISIS', 'INHIBIDO', 'TIPO_MORA', 'INFORCOMF', 'DICTAMEN', 'FECHA_INHIBICION', 'TIPO_CREDITO', 
        'OFICIAL', 'APROBADOR', 'MONTO_ENTREGADO', 'CUOTAS', 'FECHA_SOLICI', 'MONTO_SOLICI', 'MONTO_APROBADO', 
         'FECHA_APROBACION', 'EMPRESA'

         
        
    ];






    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }







    public function  sumas_saldos_deudor()
    {
        $data =  $this->db->table("deudor")
            ->select("deudor.IDNRO, concat(deudor.NOMBRES, concat(' ',deudor.APELLIDOS)) as NOMBRES, ")
            ->orderBy("created_at", "DESC")
            ->get()->getResultObject();
        return $data;
    }
}
