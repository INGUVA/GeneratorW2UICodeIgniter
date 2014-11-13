<?php
    echo '{
			"total": '.count($listaTratamiento).',
			"records":  [';
			$i=1;
			if(count($listaTratamiento)>0){
				foreach($listaTratamiento as $tratamiento){
					echo ' { "id": '.$tratamiento['Id'].', 
                    "text": "'.$tratamiento['descripcion'].'"';
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