<?php
	$this->load->helper('date')
;    echo '{
			"total": '.count($listaTratamiento).',
			"records":  [';
			$i=1;
			if(count($listaTratamiento)>0){
				foreach($listaTratamiento as $tratamiento){
					echo ' { "recid": '.$tratamiento['Id'].', 
                    "descripcion": "'.$tratamiento['descripcion'].'",
                    "fechaInicio": "'.mysql_to_w2ui($tratamiento["fechaInicio"]).'",
                    "fechaFinal": "'.mysql_to_w2ui($tratamiento["fechaFinal"]).'",
                    "pacienteId": '.$tratamiento['pacienteId'].',
                    "pacienteNombre": "'.$tratamiento['pacienteNombre'].'"
,
                    "finalizado": "';if($tratamiento['finalizado']){echo "Si";}else{echo "No";}echo '"';
               	$i++;
               	if($i>count($listaTratamiento)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>