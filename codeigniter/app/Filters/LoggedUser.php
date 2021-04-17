<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoggedUser implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        $session = \Config\Services::session();
        $request = \Config\Services::request();
         
        $uri = $request->uri;
        
        $accede_a_inicio=(  $uri->getSegment(1)=="");
       
       $no_acceso_a_login=  sizeof($uri->getSegments())==2  && $uri->getSegment(1) != "usuario" &&  $uri->getSegment(2)!= "sign_in";;

        if( !$session->has('NICK')  &&   $no_acceso_a_login )
        return $this->mandarAutenticar(); 

       if( !$session->has('NICK')  && $accede_a_inicio)
       return $this->mandarAutenticar(); 
    }

    public function mandarAutenticar(){

        $request = \Config\Services::request();
        $response = \Config\Services::response();
        $headerFormat = $request->getHeader("CHECK-AUTH");
        if (  !  is_null($headerFormat)) 
        return $response->setJSON(  ['auth_error'=> "Su sesion expiró",  'redirect'=>  base_url("usuario/sign_in") ] );
        return redirect()->to(  base_url("usuario/sign_in")); 
        
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}