<?php
/*
 * Esta vista recoge como resultado un ActionConfirmation
 * - Success: true Indica que la operación se realizó correctamente.
 * - Success: false Indica que hubo algún error, indicandolo en el mensaje.
 */
 header('Content-Type: application/json; charset=ISO-8859-1'); if($resultado->isCorrecto()){
 	 	echo '{"status": "success","message": '.json_encode(str_replace("\n", "<br/>", $resultado->getMensaje())).'}';
 }else{
 	 	echo '{"status": "error","message": '.json_encode(str_replace("\n", "<br/>", $resultado->getMensaje())).'}';
 }
?>