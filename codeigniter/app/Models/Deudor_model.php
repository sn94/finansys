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
        'CEDU_REVERSO', 'FECHA_NAC',   'BARRIO', 'EMAIL', 'SEXO', 'ESTADO_CIVIL',
        'ALQUILER_IMPORTE', 'ALQUILER_PROPIE', 'ALQUILER_TEL', 'ALQUILER_DESDE', 'TIPO_VIVIENDA',
        'REFEREN_OBT', 'OTRAS_REFEREN', 'CTAS_ACTIVAS', 'CTAS_CANCELADAS', 'ANTECEDENTES',

        //Referentes al comportamiento de pago
        'ANALISIS', 'INHIBIDO', 'INFORCOMF', 'DICTAMEN', 'FECHA_INHIBICION',
 
        
        //Conyuge
     /*   'CEDULA_CONYU', 'CONYUGE', 'CONYUGE_OCUPACION', 'CONYUGE_ANTIGUEDAD', 'CONYUGE_EMPRESA', 'CONYUGE_TEL_TRABAJO',
        'CONYUGE_DIR_TRABAJO', 'CONYUGE_CARGO_TRABAJO', 'CONYUGE_UNIDAD_TRABAJO', 'CONYUGE_TELEF', 'CONYUGE_SUELDO',
*/
        //Otros parientes
        /*'FAMILIAR1', 'FAMILIAR1_TELEF', 'FAMILIAR1_EMPLEO',
        'FAMILIAR2', 'FAMILIAR2_TELEF', 'FAMILIAR2_EMPLEO',
        'FAMILIAR3', 'FAMILIAR3_TELEF', 'FAMILIAR3_EMPLEO',*/

        //Laborales

        


        //posesiones
        'INMUEBLE', 'INMUEBLE_VALOR', 'INMUEBLE_ESCRITURA', 'INMUEBLE_ACLARACION', 'NRO_FINCA', 'CTA_CATASTRAL',


        'AUTO_MARCA', 'AUTO_MODELO', 'AUTO_CHAPA',



        //Para usarlo en operacion
        'MONTO_SOLICI', 'FECHA_SOLICITUD',
        'TIPO_MORA', 'TIPO_CREDITO', 'OFICIAL_CREDITO', 
        'FECHA_APROBACION', 'APROBADO_POR', 'MONTO_ENTREGADO', 'EMPRESA'



    ];






    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }
}
