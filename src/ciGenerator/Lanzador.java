package ciGenerator;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;

import ciGenerator.config.GenerarBaseDatos;


public class Lanzador {

	/**
	 * @param args
	 */
	public static void main(String[] args) {		
		//Obtengo la ruta a la carpeta
		String rutaFuente = args[0];
		File fileFuente = new File(rutaFuente);
		
		String rutaDestino = args[1];
		File fileDestino = new File(rutaDestino);
		
		//Obtengo el listado de los ficheros a crear
		if(!fileFuente.exists()){
			System.out.println("La ruta del directorio fuente no existe.");
			return;
		}
		
		if(!fileFuente.isDirectory()){
			System.out.println("La ruta del directorio fuente no es un directorio.");
			return;
		}
		
		//Obtengo el listado de los ficheros a crear
		if(!fileDestino.exists()){
			System.out.println("La ruta del directorio destino no existe.");
			return;
		}
		
		if(!fileDestino.isDirectory()){
			System.out.println("La ruta del directorio destino no es un directorio.");
			return;
		}
				
		String[] ficheros = fileFuente.list();
		ArrayList<GenerarClase> clases = new ArrayList<GenerarClase>();
	
		for(String fichero : ficheros){
			if(fichero.contains(".txt")){
				try {
					GenerarClase clase = FicheroClase.ObtenerClase(fileFuente+"/"+fichero);
					clases.add(clase);
					clase.Load(rutaDestino);
				} catch (Exception e) {
					System.out.println("Error en fichero: "+fichero+" ");
					e.printStackTrace();
				}				
			}
		}
		
		//Creacion del fichero de configuracion de la base de datos
		GenerarBaseDatos.Iniciar(rutaDestino,clases);
		
	
	}

}
