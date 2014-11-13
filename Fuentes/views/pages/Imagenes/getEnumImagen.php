<?php
    echo '{
			"total": '.count($listaImagen).',
			"records":  [';
			$i=1;
			if(count($listaImagen)>0){
				foreach($listaImagen as $imagen){
					echo ' { "id": '.$imagen['Id'].', 
                    "text": "'.$imagen['nombre'].'"';
               	$i++;
               	if($i>count($listaImagen)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>