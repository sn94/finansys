<?php namespace App\Models;

use CodeIgniter\Model;

class  Cobro_model extends Model
{
    
    protected $table = 'cobro';

    protected $primaryKey = 'IDNRO';

    protected $returnType     = 'object';/** */

    protected $allowedFields = 
    ['FECHA','CAJERO','DEUDOR','CAJA','EFECTIVO_T','ESTADO','IDPRESTAMO',
    'CHEQUE_IMPO','CHEQUE_NRO','CHEQUE_BANC','TARJE_IMPO','TARJE_TIPO','TARJE_VOUCH','OBS'];
    


    public function __construct()
    {
        parent::__construct();
        $this->db= \Config\Database::connect();
        $this->request = \Config\Services::request();
    }


    public function cobrar(){
        $cobro= $this->request->getPost("CABECERA");  
         //Cabecera
        $this->insert(  $cobro  );//GRABAR CABECERA
        $id_cobro= $this->insertID(); 
        $this->cobrar_cuotas( $id_cobro);
        return  $id_cobro;
    }

    public function  cobrar_cuotas( $id_cobro){
        $cobro= $this->request->getPost("CABECERA");   
        $id_prestamo= $cobro['IDPRESTAMO'];
        //total importes: efectivo, cheque y tarjeta
        $TOTAL_IMPORTE=  intval($cobro['EFECTIVO_T']) + intval($cobro['TARJE_IMPO']) + intval($cobro['CHEQUE_IMPO']);
        //Detalles 
        $id_cuotas_marcadas= $this->request->getPost("ESTADO");//OBTENER IDS DE CUOTAS MARCADAS
        //Actualizar estado de cuotas
        foreach( $id_cuotas_marcadas as $cuota){
           
            if( $TOTAL_IMPORTE <=0)  break;

            //SOLO MARCAR SI LA CUOTA HA SIDO TOTALMENTE PAGADA

            //monto
            $monto= ( new Cuotas_model())->calc_saldo($cuota);  //MONTO ABSOLUTO
            //para el detalle de cobro
            //eL MONTO DE IMPORTE POR CUOTA ES VARIABLE
            $monto_cuota= $monto;

            if( $TOTAL_IMPORTE>=  $monto)
            $this->db->table('cuotas_prestamo')->set("ESTADO", "C")->where("IDPRESTAMO", $id_prestamo)->where("IDNRO", $cuota)->update();
            else $monto_cuota= $TOTAL_IMPORTE;//Si el pago de la cuota es Parcial


             //ACTUALIZAR FECHA DE PAGO
             if( $TOTAL_IMPORTE>=  $monto)
             {
                 $this->db->table("cuotas_prestamo")->set("FECHA_PAGO" , date("Y-m-j") )->where("IDNRO", $cuota)->update();
                 //determinar el atraso entre fecha de pago y vencimiento
                 //PUEDE HACER POR CONSULTA SQL
            }
           
            $TOTAL_IMPORTE-= intval($monto);


             //guardar detalle de cobro
            $this->db->table('detalle_cobro')
            ->insert([ 'IDCOBRO'=>$id_cobro, 'IDCUOTA'=> $cuota, 'IMPORTE'=> $monto_cuota]);
            /*********************** */
       }


       //********************************* */
       //YA SE HA COBRADO LA TOTALIDAD DE CUOTAS?
       $cuotas_model= new Cuotas_model();
       $BuilderCuota=$cuotas_model->builder();
       $TotalCuotas=  $BuilderCuota->where("IDPRESTAMO", $id_prestamo)->countAllResults();//NUMERO DE CUOTAS
       $TotalCuotasCobradas=  $BuilderCuota->where("IDPRESTAMO", $id_prestamo)->where("ESTADO", "C")->countAllResults();//NUMERO DE CUOTAS
       if( $TotalCuotas == $TotalCuotasCobradas )
            $this->db->table("prestamo")->set("ESTADO" , "L")->where("IDNRO", $id_prestamo)->update();
       /** END LIQUIDACION DE PRESTAMO  */      
    }

}