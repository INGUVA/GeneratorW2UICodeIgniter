package ciGenerator.model;

import ciGenerator.model.tipos.TipoDatos;



public class Propiedad {


	private String nombre;			//Indica el nombre de la propiedad
	private String label; 			//Etiqueta que se muestra en el panel de control
	private String nombreBaseDatos;	//Nombre que se utiliza en la base de datos
	private TipoDatos tipo;		//Tipo de datos int, text, double...
	private boolean editableWeb;	//Es editable desde el panel de control?
	private boolean visibleWeb;		//Es visible desde el panel de control?
	private boolean requerido;		//Es un campo obligatorio?
	private boolean busquedasPor;	//Se puede buscar por este campo?
	private boolean ordenarPor;		//Se puede ordenar por este campo?
	private String htmlTitle;		//Titulo que se muestra en los campos en las vistas html
	private String htmlPlaceHolder;	//Texto que se muestra en los input en las vistas html
	private int htmlMinLength;		//Longitud mínima en los input tipo text
	private int htmlMaxLenght;		//Longitud máxima en los input tipo text
	private int htmlSize;			//Tamañao del input en los input tipo text
	private boolean isMostrar;		//Apartece en campo mostrar
	
	//Solo tipo ENUM
	private String urlPosiblesValores;	//Url que devuelve los posibles valores si es de tipo enum
	
	public Propiedad(String nombre, String nombreBaseDatos, String label, TipoDatos tipo,  boolean isVisibleWeb, boolean isEditableWeb, boolean requerido, boolean busquedasPor, boolean ordenarPor, String htmlTitle, String htmlPlaceholder, int htmlMinLength, int htmlMaxLength, int htmlSize, boolean isMostrar){
		this.nombre = nombre;
		this.nombreBaseDatos = nombreBaseDatos;
		this.tipo = tipo;
		this.visibleWeb = isVisibleWeb;
		this.editableWeb = isEditableWeb;
		this.label = label;
		this.requerido = requerido;
		this.busquedasPor = busquedasPor;
		this.ordenarPor = ordenarPor;
		this.htmlTitle = htmlTitle;
		this.htmlPlaceHolder = htmlPlaceholder;
		this.htmlMinLength = htmlMinLength;
		this.htmlMaxLenght = htmlMaxLength;
		this.htmlSize = htmlSize;
		this.isMostrar = isMostrar;
	}

	public String getNombre() {
		return nombre;
	}

	public void setNombre(String nombre) {
		this.nombre = nombre;
	}

	public String getNombreBaseDatos() {
		return nombreBaseDatos;
	}

	public void setNombreBaseDatos(String nombreBaseDatos) {
		this.nombreBaseDatos = nombreBaseDatos;
	}

	public TipoDatos getTipo() {
		return tipo;
	}

	public void setTipo(TipoDatos tipo) {
		this.tipo = tipo;
	}

	public boolean isVisibleWeb() {
		return visibleWeb;
	}

	public void setVisibleWeb(boolean isVisibleWeb) {
		this.visibleWeb = isVisibleWeb;
	}

	public String getLabel() {
		return label;
	}

	public void setLabel(String label) {
		this.label = label;
	}

	public boolean isEditableWeb() {
		return editableWeb;
	}

	public void setEditableWeb(boolean editableWeb) {
		this.editableWeb = editableWeb;
	}

	public boolean isRequerido() {
		return requerido;
	}

	public void setRequerido(boolean requerido) {
		this.requerido = requerido;
	}
	

	public boolean isMostrar() {
		return isMostrar;
	}

	public void setIsMostrar(boolean isMostrar) {
		this.isMostrar = isMostrar;
	}

	public boolean isBusquedasPor() {
		return busquedasPor;
	}

	public void setBusquedasPor(boolean busquedasPor) {
		this.busquedasPor = busquedasPor;
	}
	
	public boolean isOrdenarPor() {
		return ordenarPor;
	}

	public void setOrdenarPor(boolean ordenarPor) {
		this.ordenarPor = ordenarPor;
	}

	public String getUrlPosiblesValores() {
		return urlPosiblesValores;
	}

	public void setUrlPosiblesValores(String urlPosiblesValores) {
		this.urlPosiblesValores = urlPosiblesValores;
	}

	public String getHtmlTitle() {
		return htmlTitle;
	}

	public void setHtmlTitle(String htmlTitle) {
		this.htmlTitle = htmlTitle;
	}

	public String getHtmlPlaceHolder() {
		return htmlPlaceHolder;
	}

	public void setHtmlPlaceHolder(String htmlPlaceHolder) {
		this.htmlPlaceHolder = htmlPlaceHolder;
	}

	public int getHtmlMinLength() {
		return htmlMinLength;
	}

	public void setHtmlMinLength(int htmlMinLength) {
		this.htmlMinLength = htmlMinLength;
	}

	public int getHtmlMaxLenght() {
		return htmlMaxLenght;
	}

	public void setHtmlMaxLenght(int htmlMaxLenght) {
		this.htmlMaxLenght = htmlMaxLenght;
	}

	public int getHtmlSize() {
		return htmlSize;
	}

	public void setHtmlSize(int htmlSize) {
		this.htmlSize = htmlSize;
	}


}
