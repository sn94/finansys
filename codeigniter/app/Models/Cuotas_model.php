<?php namespace App\Models;

use CodeIgniter\Model;

class Cuotas_model extends Model
{
    
    protected $table = 'cuotas_prestamo';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    [ 'IDPRESTAMO', 'NUMERO', 'MONTO','VENCIMIENTO','FECHA_PAGO','ESTADO'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
    }




    public function calc_saldo( $IDCUOTA){
        $TOTAL= intval( ($this->find($IDCUOTA))->MONTO ); 
       $COBRADO= intval(  $this->db->table('detalle_cobro')->where("IDCUOTA", $IDCUOTA)->selectSum("IMPORTE")->get()->getRow()->IMPORTE );
       $SALDO=  $TOTAL -  $COBRADO;
       return $SALDO;

    }
}