<?php
	$this->load->helper('date')
;    echo '{
          status: "success",
          record:  ';
               echo ' { "recid": '.$imagen->getId().', 
                    "nombre": "'.$imagen['nombre'].'",
                    "fechaCaptura": "'.mysql_to_w2ui($imagen["fechaCaptura"]).'",
                    "ruta": "'.$imagen['ruta'].'",
                    "pacienteId": '.$imagen['pacienteId'].',
                    "pacienteNombre": "'.$imagen['pacienteNombre'].'"';
 echo '     		}
     }';
?>