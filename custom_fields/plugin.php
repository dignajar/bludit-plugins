<?php

class pluginCustomFields extends Plugin
{
	private $fields;
	const FIELD_KEY = 'customFields';

	private $addedFields = array();
	private $isDefined = false;

	public function init()
	{
		$this->dbFields = array(
			$this::FIELD_KEY => '{}'
		);

		$GLOBALS[$this::FIELD_KEY] = $this;
	}

	public function load()
	{
		$fieldsJson = $this->getDbField($this::FIELD_KEY, false);
		$this->fields = json_decode($fieldsJson);
	}

	public function save()
	{
		if (!$this->installed())
			return;

		// Remove empty fields, which are not in use by templates
		foreach ($this->fields as $key => $value) {
			if (!in_array($key, $this->addedFields)) {
				unset($this->fields->$key);
			}
		}

		$fieldsJson = json_encode($this->fields);
		$this->dbFields[$this::FIELD_KEY] = $fieldsJson;
		$this->setDb($this->dbFields);
	}

	public function form()
	{
		$html = '';

		$html .= '<div>';
		$html .= '<input type="hidden" id="fieldJson" name="' . $this::FIELD_KEY . '" value="' . $this->getDbField($this::FIELD_KEY) . '" />';
		$html .= '</div>';
		$html .= '<div id="fieldInputs"></div>';

		$html .= '
		<script>
			var $jsonInput = $("#fieldJson");
			var $inputContainer = $("#fieldInputs");
			var $form = $jsonInput.closest("form");
			var $data = JSON.parse($jsonInput.val());
			$.each($data, function( index, value ) {
  				$inputContainer.append("<label><b>"+index+"</b></label>"); 
  				$inputContainer.append("<input type=\'text\' name=\'"+index+"\' value=\'"+value+"\'>"); 
  				$inputContainer.append("<br><br>"); 
			});
			
			$form.submit(function(){
				var newData = {};

				$.each($inputContainer.children("input"), function( index, input ) {
					$input = $(input);
					newData[$input.attr("name")] = $input.val();
				});
				
				$jsonInput.val(JSON.stringify(newData));
			})
		</script>';

		return $html;
	}

	public function get($key)
	{
		if (!$this->installed())
			return false;

		if (!isset($this->fields))
			$this->load();

		if (!isset($this->fields->$key))
			throw new Exception("Template Parameter $key is not declared");

		return $this->fields->$key;
	}

	public function define($keys)
	{
		if (!$this->installed())
			return false;

		if ($this->isDefined)
			throw new Exception('You can only define custom fields once in your template');


		if (!isset($this->fields))
			$this->load();

		foreach ($keys as $key => $defaultValue) {
			if (!isset($this->fields->$key)) {
				$this->fields->$key = $defaultValue;
			}
			array_push($this->addedFields, $key);
		}

		$this->save();

		$this->isDefined = true;
	}
}