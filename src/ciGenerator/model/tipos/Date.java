package ciGenerator.model.tipos;

import org.json.JSONObject;

public class Date extends TipoDatos {

	public Date(JSONObject jOpciones){
		
	}
	
	@Override
	public String GetTipoW2UI() {
		return TipoW2UI.date.toString();
	}

	@Override
	public String GetInputW2UI() {
		return InputW2UI.text.toString();
	}

	@Override
	public boolean isSimple() {
		return true;
	}

	@Override
	public Object getValorPorDefecto() {
		return "";
	}

}
