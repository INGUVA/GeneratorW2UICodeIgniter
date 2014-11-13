<?php
	$this->load->helper('date')
;    echo '{
          status: "success",
          record:  ';
               echo ' { "recid": '.$fichero->getId().', 
                    "nombre": "'.$fichero['nombre'].'",
                    "fechaCaptura": "'.mysql_to_w2ui($fichero["fechaCaptura"]).'",
                    "ruta": "'.$fichero['ruta'].'",
                    "pacienteId": '.$fichero['pacienteId'].',
                    "pacienteNombre": "'.$fichero['pacienteNombre'].'"';
 echo '     		}
     }';
?>