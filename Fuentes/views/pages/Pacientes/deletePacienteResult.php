<?php
/*
 * Esta vista recoge como resultado un ActionConfirmation
 * - Success: true Indica que la operación se realizó correctamente.
 * - Success: false Indica que hubo algún error, indicandolo en el mensaje.
 */
 if($resultado->isCorrecto()){
 	echo '{"status": "success"}';
 }else{
	echo '{"status": "error", "message": "'.$resultado->getMensaje().'"}';
 }
?>