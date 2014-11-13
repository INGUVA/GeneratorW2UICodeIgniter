<?php
	$this->load->helper('date')
;    echo '{
          status: "success",
          record:  ';
               echo ' { "recid": '.$video->getId().', 
                    "nombre": "'.$video['nombre'].'",
                    "fechaCaptura": "'.mysql_to_w2ui($video["fechaCaptura"]).'",
                    "ruta": "'.$video['ruta'].'",
                    "pacienteId": '.$video['pacienteId'].',
                    "pacienteNombre": "'.$video['pacienteNombre'].'"';
 echo '     		}
     }';
?>