package ciGenerator;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.nio.charset.Charset;
import java.nio.charset.StandardCharsets;
import java.util.ArrayList;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import ciGenerator.model.Propiedad;
import ciGenerator.model.tipos.TipoDatos;
import ciGenerator.ui.Pestana;




public class FicheroClase {

	
	public static GenerarClase ObtenerClase(String path) throws Exception{
		String content;
		JSONObject jObject = null;
		try {
			content = readFile(path, StandardCharsets.ISO_8859_1);
			jObject = new JSONObject(content);
		} catch (IOException e) {
			e.printStackTrace();
		} catch (JSONException e) {
			e.printStackTrace();
		}
		
		String nombreClase = jObject.getString("Nombre");
		String nombreTablaBD = jObject.getString("NombreTablaBD");
		String nombreVistaBD = jObject.getString("NombreVistaBD");
		JSONArray jsonPropiedades = jObject.getJSONArray("Propiedades");
		int i = 0 ;
		ArrayList<Propiedad> propiedades = new ArrayList<Propiedad>();
		while(i<jsonPropiedades.length()){
			JSONObject jPropiedad = jsonPropiedades.getJSONObject(i);
			String nombreCampo = jPropiedad.getString("Nombre");
			String nombreBD = jPropiedad.getString("NombreBD");
			
			JSONObject tipo = jPropiedad.getJSONObject("Tipo");
			boolean visibleWeb = jPropiedad.optBoolean("VisibleWeb");
			boolean editableWeb = jPropiedad.optBoolean("EditableWeb");
			boolean requeridoWeb= jPropiedad.optBoolean("Requerido");
			boolean buscarPor	= jPropiedad.optBoolean("BuscarPor");
			boolean ordenarPor  = jPropiedad.optBoolean("OrdenarPor");
			String label = jPropiedad.optString("Label", nombreCampo);
			JSONObject jHtml = jPropiedad.getJSONObject("html");
			String htmlTitle = jHtml.optString("Title","");
			String htmlPlaceholder = jHtml.optString("Placeholder","");
			int htmlMinLength = jHtml.optInt("MinLength");
			int htmlMaxLength = jHtml.optInt("MaxLength");
			int size = jHtml.optInt("Size");
			boolean isMostrar = jPropiedad.optBoolean("Mostrar");
			
			propiedades.add(new Propiedad(nombreCampo, nombreBD, label, TipoDatos.CreateTipoDatos(tipo), visibleWeb, editableWeb, requeridoWeb,buscarPor, ordenarPor, htmlTitle, htmlPlaceholder, htmlMinLength, htmlMaxLength, size, isMostrar));
			i++;
		}
		//Pestanas formularios
		ArrayList<Pestana> pestanas = new ArrayList<Pestana>();
		JSONObject jsonFormulario = jObject.getJSONObject("Formulario");
		JSONArray jsonPestanas = jsonFormulario.getJSONArray("Pestañas");
		i=0;
		while(i<jsonPestanas.length()){
			Pestana p = new Pestana(jsonPestanas.getJSONObject(i).getString("Nombre"), jsonPestanas.getJSONObject(i).getInt("NumeroCampos"));
			pestanas.add(p);
			i++;
		}
		
		//Lista
		JSONObject jLista = jObject.getJSONObject("Lista");
		boolean createOptions = jLista.getBoolean("Create");
		boolean editOptions	= jLista.getBoolean("Edit");
		boolean deleteOptions	= jLista.getBoolean("Delete");
		GenerarClase clase = new GenerarClase();
		clase.setNombre(nombreClase);
		clase.setNombreTablaBD(nombreTablaBD);
		clase.setNombreVistaBD(nombreVistaBD);
		clase.setPropiedades(propiedades);
		clase.setPestanas(pestanas);
		clase.setCreate(createOptions);
		clase.setEdit(editOptions);
		clase.setDelete(deleteOptions);
		return clase;
	}

	/**
	 * Convierte el contenido de un fichero a un String
	 * @param path
	 * @param encoding
	 * @return
	 * @throws IOException
	 */
	public static String readFile(String path, Charset encoding) throws IOException {
		byte[] encoded = convertFileToByteArray(new File(path));
		String contenido = new String(encoded);
		return contenido;
		//byte[] encoded = Files.readAllBytes(Paths.get(path));
		//return encoding.decode(ByteBuffer.wrap(encoded)).toString();
	}
	
	public static byte[] convertFileToByteArray(File f) {
		byte[] byteArray = null;
		try {
			InputStream inputStream = new FileInputStream(f);
			ByteArrayOutputStream bos = new ByteArrayOutputStream();
			byte[] b = new byte[1024 * 8];
			int bytesRead = 0;

			while ((bytesRead = inputStream.read(b)) != -1) {
				bos.write(b, 0, bytesRead);
			}
			byteArray = bos.toByteArray();
			inputStream.close();
			bos.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
		return byteArray;
	}
}
