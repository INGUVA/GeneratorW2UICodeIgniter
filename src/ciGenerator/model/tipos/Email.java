package ciGenerator.model.tipos;

public class Email extends TipoDatos{

	@Override
	public String GetTipoW2UI() {
		return TipoW2UI.email.toString();
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
		return true;
	}

}
