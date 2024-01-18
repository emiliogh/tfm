<?php 
class MySQL{
  private $conexion; 
  private $total_consultas;
  public function MySQL(){ 
    if(!isset($this->conexion)){
      $this->conexion = mysqli_connect('db','MYSQL_USER','MYSQL_PASSWORD','MY_DATABASE');
	    //$this->conexion = (new mysqli('db','MYSQL_USER','MYSQL_PASSWORD','MY_DATABASE'))
      //or die(mysqli_error());
    }
  }
  public function consulta($consulta){ 
    $this->total_consultas++; 
	//echo $consulta;
  $resultado = mysqli_query($this->conexion,$consulta);
  if(!$resultado){ 
	  $ip = $_SERVER['REMOTE_ADDR'];
	  $navegador = $_SERVER['HTTP_USER_AGENT'];
	  $msj = 'MySQL Error: '.mysqli_errno($this->conexion).'_'.mysqli_error($this->conexion).'_'.$resultado;
	  $r = mysqli_query($this->conexion," insert into tbs_sqlerror (sql_,fecha,error,ip,informacion) values('".str_replace("'",'#',$consulta)."',now(),'".str_replace("'",'',$msj)."','".$ip."','".$navegador."');");
      return 'ERROR';
    }
    return $resultado;
  }
  public function fetch_array($consulta){
   return mysqli_fetch_array($consulta);
  }
  public function num_rows($consulta){
   return mysqli_num_rows($consulta);
  }
  public function getTotalConsultas(){
   return $this->total_consultas; 
  }
}

?>
