<?php
require_once 'Database.php';
class Mail
{
 private $remitente;
 private $destino;
 private $asunto;
 private $mensaje;
 private $encabezados;

 public function Mail($remitente=null,$destino=null,$asunto=null,$mensaje=null,$encabezados=null)
 {
   $this->remitente=$remitente;
   $this->destino=$destino;
   $this->asunto=$asunto;
   $this->mensaje=$mensaje;
   $this->encabezados=$encabezados;
 }
 
 //getter
 public function getRemitente() {
      return $this->remitente;
  }
    
 public function getDestino() {
      return $this->destino;
 }
   
 public function getAsunto() {
      return $this->asunto;
 }
    
 public function getMensaje() {
      return $this->mensaje;
 }
    
 public function getEncabezados() {
      return $this->encabezados;
 }
 
 //setter
 public function setRemitente($remitente) {
     $this->remitente = $remitente;
 }

 public function setDestino($destino) {
     $this->destino = $destino;
 }

 public function setAsunto($asunto) {
     $this->asunto = $asunto;
 }
 
 public function setMensaje($mensaje) {
     $this->mensaje = $mensaje;
 }

 public function setEncabezados($encabezados) {
     $this->encabezados = $encabezados;
 }
 
 public function sendMail()
 {
     try
     {
        if($this->getDestino() != null)
        {
            mail($this->getDestino(), $this->getAsunto(), $this->getMensaje(), $this->getEncabezados()) or die ("Su mensaje no se envio.");
            return true;
        }
        else 
        {
            return false;
        }
     }
     catch(Exception $e)
     {
         return false;
     }
 }
}
?>