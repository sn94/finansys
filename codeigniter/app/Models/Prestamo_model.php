<?php namespace App\Models;

use CodeIgniter\Model;

class  Prestamo_model extends Model
{
    
    protected $table = 'prestamo';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $useTimestamps= true;

    protected $allowedFields =
    [
        'FECHA_SOLICI', 'MONTO_SOLICI', 'MONTO_APROBADO',  'DEUDOR', 'GARANTE', 'ESTADO', 'FECHA_ENTREGA',
         'FECHA_INI_COBRO',
        'FECHA_APROBACION', 'FECHA_RECHAZO', 'CAT_MONTO', 'FUNCIONARIO', 'FUNCIONARIO_APROB', 'FUNCIONARIO_RECHA',
         'OBSERVACION'
    ];
    
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
        $this->request = \Config\Services::request();
    }



    public function aprobar(){

        $ID_prestamo=  $this->request->getPost("IDNRO");
        $prestamo_data=  $this->request->getPost("cabecera");
        $this->transStart();
        $this->update( $ID_prestamo ,  $prestamo_data);
        //generar_cuotas
        $vencimientos= $this->request->getPost("vencimientos");
        $montos= $this->request->getPost("montos");
        $NUMERO= 1;
        for( $f= 0; $f< sizeof($vencimientos) ; $f++){
             $this->db->table('cuotas_prestamo')
            ->insert([   'IDPRESTAMO'=> $ID_prestamo, 'NUMERO'=>$NUMERO,   'MONTO'    => $montos[$f],  'VENCIMIENTO'   => $vencimientos[$f]
            ]);
            $NUMERO++;
        }
        $this->transComplete();
        return $this->transStatus();
    }
   
  


    public function obtener_cuotas($ID_prestamo,$estado= "P"){
        return $this->db->table('cuotas_prestamo')
        ->where("IDPRESTAMO", $ID_prestamo)
        ->where("ESTADO", $estado)
        ->select('cuotas_prestamo.*')
        ->select("IFNULL((SELECT SUM(IMPORTE) FROM detalle_cobro where IDCUOTA=cuotas_prestamo.IDNRO),0) AS SUMA")
        ->select("(cuotas_prestamo.MONTO -  IFNULL((SELECT SUM(IMPORTE) FROM detalle_cobro where IDCUOTA=cuotas_prestamo.IDNRO),0) ) AS SALDO")
        
        
        ->get()->getResult();
    }



 
}