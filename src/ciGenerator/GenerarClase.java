package ciGenerator;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;

import ciGenerator.controller.GenerarController;
import ciGenerator.js.GenerarJs;
import ciGenerator.library.GenerarService;
import ciGenerator.model.GenerarModelo;
import ciGenerator.model.Propiedad;
import ciGenerator.ui.GenerarViews;
import ciGenerator.ui.Pestana;

public class GenerarClase {

	private String nombre;
	private String nombreTablaBD;
	private String nombreVistaBD;
	private ArrayList<Propiedad> propiedades;
	private ArrayList<Pestana> pestanas;
	private boolean create;
	private boolean edit;
	private boolean delete;

	public GenerarClase() {
	}

	public ArrayList<Propiedad> getPropiedades() {
		return propiedades;
	}

	public void setPropiedades(ArrayList<Propiedad> propiedades) {
		this.propiedades = propiedades;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}
	
	public String getNombreTablaBD(){
		return nombreTablaBD;
	}
	
	public void setNombreTablaBD(String _nombreTablaBD){
		this.nombreTablaBD = _nombreTablaBD;
	}
	
	public String getNombreVistaBD(){
		return nombreVistaBD;
	}
	
	public void setNombreVistaBD(String _nombreVistaBD){
		this.nombreVistaBD = _nombreVistaBD;
	}

	public void Load(String path) throws FileNotFoundException,UnsupportedEncodingException {

		// Creación del fichero /models/<nombreclase>.php
		File file = new File(path + "/models");
		if (!file.exists()) {
			file.mkdir();
		}
		PrintWriter writerModelo = new PrintWriter(path + "/models/" + nombre.toLowerCase() + ".php", "UTF-8");
		writerModelo.print(GenerarModelo.Iniciar(nombre, propiedades));
		writerModelo.close();

		// Creación del fichero /libraries/Service<nombreclase>.php
		file = new File(path + "/libraries");
		if (!file.exists()) {
			file.mkdir();
		}
		PrintWriter writerService = new PrintWriter(path + "/libraries/service" + nombre + ".php", "UTF-8");
		writerService.print(GenerarService.Iniciar(nombre, propiedades));
		writerService.close();

		// Creación del fichero /controller/Service<nombreclase>.php
		file = new File(path + "/controller");
		if (!file.exists()) {
			file.mkdir();
		}
		
		PrintWriter writerController = new PrintWriter(path + "/controller/" + Utils.ConvertirAPlurar(nombre.toLowerCase()) + ".php","UTF-8");
		writerController.print(GenerarController.Iniciar(nombre, propiedades));
		writerController.close();
		
		PrintWriter writerControllerBase = new PrintWriter(path + "/controller/" + Utils.ConvertirAPlurar(nombre.toLowerCase()) + "_base.php","UTF-8");
		writerControllerBase.print(GenerarController.IniciarBase(nombre, propiedades));
		writerControllerBase.close();

		// Creación del fichero /views/<nombreclase>S/listajsonweb.php
		file = new File(path + "/views/pages/" + Utils.ConvertirAPlurar(nombre));
		if (!file.exists()) {
			file.mkdirs();
		}

		//Creación de getJson
		PrintWriter writerViewJson = new PrintWriter(path + "/views/pages/" + Utils.ConvertirAPlurar(nombre) + "/get" + nombre + "Json.php", "UTF-8");
		writerViewJson.print(GenerarViews.LoadViewJson(nombre, propiedades));
		writerViewJson.close();

		//Creación de la lista getListJson
		PrintWriter writerViewListJson = new PrintWriter(path + "/views/pages/" + Utils.ConvertirAPlurar(nombre) + "/getLista" + nombre + "Json.php", "UTF-8");
		writerViewListJson.print(GenerarViews.LoadViewListJson(nombre, propiedades));
		writerViewListJson.close();

		//Creación de enum
		PrintWriter writerViewEnum = new PrintWriter(path + "/views/pages/" + Utils.ConvertirAPlurar(nombre) + "/getEnum" + nombre+".php", "UTF-8");
		writerViewEnum.print(GenerarViews.LoadViewListEnum(nombre, propiedades));
		writerViewEnum.close();
		
		// Creacion de la vista que contiene el formulario de creación de un
		// nuevo elemento
		PrintWriter writerViewNewForm = new PrintWriter(path + "/views/pages/"+ Utils.ConvertirAPlurar(nombre) + "/formNuevo" + nombre + ".php", "UTF-8");
		writerViewNewForm.print(GenerarViews.LoadViewVistaFormNuevo(nombre,propiedades, pestanas));
		writerViewNewForm.close();

		// Creacion de la vista que contiene el formulario de creación de un
		// nuevo elemento
		PrintWriter writerViewUpdateForm = new PrintWriter(path + "/views/pages/" + Utils.ConvertirAPlurar(nombre) + "/formModificar" + nombre+ ".php", "UTF-8");
		writerViewUpdateForm.print(GenerarViews.LoadViewVistaFormUpdate(nombre,propiedades, pestanas));
		writerViewUpdateForm.close();

		// Creación de la vista que contiene el resultado de la eliminación
		PrintWriter writerViewResultNewJson = new PrintWriter(path+ "/views/pages/" + Utils.ConvertirAPlurar(nombre) + "/new" + nombre + "Result.php","UTF-8");
		writerViewResultNewJson.print(GenerarViews.LoadViewVistaNewResult());
		writerViewResultNewJson.close();

		// Creación de la vista que contiene el resultado de la modificación
		PrintWriter writerViewResultUpdateJson = new PrintWriter(path+ "/views/pages/" + Utils.ConvertirAPlurar(nombre) + "/update" + nombre + "Result.php","UTF-8");
		writerViewResultUpdateJson.print(GenerarViews.LoadViewVistaUpdateResult());
		writerViewResultUpdateJson.close();

		// Creación de la vista que contiene el resultado de la eliminación
		PrintWriter writerViewResultDeleteJson = new PrintWriter(path+ "/views/pages/" + Utils.ConvertirAPlurar(nombre) + "/delete" + nombre + "Result.php","UTF-8");
		writerViewResultDeleteJson.print(GenerarViews.LoadViewVistaDeleteResult());
		writerViewResultDeleteJson.close();

		/************** SCRIPTS *********************/
		// Creación del fichero /views/<nombreclase>S/listajsonweb.php
		file = new File(path + "/js");
		if (!file.exists()) {
			file.mkdir();
		}

		// Creacion del fichero que contiene el script de la creación de la
		// tabla
		PrintWriter writerViewsScriptLista = new PrintWriter(path
				+ "/js/scripts" + nombre + ".js", "UTF-8");
		writerViewsScriptLista.print(GenerarJs.Iniciar(nombre, propiedades,
				pestanas, create, edit, delete));
		writerViewsScriptLista.close();

	}

	public ArrayList<Pestana> getPestanas() {
		return pestanas;
	}

	public void setPestanas(ArrayList<Pestana> pestanas) {
		this.pestanas = pestanas;
	}
	
	public boolean isCreate(){
		return create;
	}
	
	public void setCreate(boolean create){
		this.create = create;
	}

	public boolean isEdit() {
		return edit;
	}

	public void setEdit(boolean edit) {
		this.edit = edit;
	}

	public boolean isDelete() {
		return delete;
	}

	public void setDelete(boolean delete) {
		this.delete = delete;
	}
}
