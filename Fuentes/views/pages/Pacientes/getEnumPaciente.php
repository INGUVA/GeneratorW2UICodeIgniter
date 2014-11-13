<?php
    echo '{
			"total": '.count($listaPaciente).',
			"records":  [';
			$i=1;
			if(count($listaPaciente)>0){
				foreach($listaPaciente as $paciente){
					echo ' { "id": '.$paciente['Id'].', 
                    "text": "'.$paciente['nombre'].'"';
               	$i++;
               	if($i>count($listaPaciente)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>