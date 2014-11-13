<?php
    echo '{
			"total": '.count($listaFichero).',
			"records":  [';
			$i=1;
			if(count($listaFichero)>0){
				foreach($listaFichero as $fichero){
					echo ' { "id": '.$fichero['Id'].', 
                    "text": "'.$fichero['nombre'].'"';
               	$i++;
               	if($i>count($listaFichero)){
                   	echo '	}';
               	}else{
                   	echo '	},';
               	}
               }
           }
 echo '     ]
    }';
?>