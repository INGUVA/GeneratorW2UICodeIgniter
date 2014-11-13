<?php
	$this->load->helper('date')
;    echo '{
          status: "success",
          record:  ';
               echo ' { "recid": '.$tratamiento->getId().', 
                    "descripcion": "'.$tratamiento['descripcion'].'",
                    "fechaInicio": "'.mysql_to_w2ui($tratamiento["fechaInicio"]).'",
                    "fechaFinal": "'.mysql_to_w2ui($tratamiento["fechaFinal"]).'",
                    "pacienteId": '.$tratamiento['pacienteId'].',
                    "pacienteNombre": "'.$tratamiento['pacienteNombre'].'",
                    "finalizado": "';if($tratamiento['finalizado']){echo "Si";}else{echo "No";}echo '"';
 echo '     		}
     }';
?>