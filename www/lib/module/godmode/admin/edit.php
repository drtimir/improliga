<?

$this->req('model');
$this->req('link_redir');

$model = System\Loader::get_class_from_model($model);

def($id);
def($new, false);
def($heading, t($new ? 'godmode_create_object':'godmode_edit_object', strtolower(System\Model\Attr::get_model_model_name($model))));
def($attrs_edit, array());
def($attrs_edit_exclude, array());

$item  = $new ? (new $model()):find($model, $id);
$attrs = array();
$x = 0;

if (empty($attrs_edit)) {
	$attrs_edit = System\Model\Database::get_model_attr_list($model);
}

$banned_attrs = array(System\Model\Database::get_id_col($model), 'created_at', 'updated_at');

foreach ($attrs_edit as $alias=>$attr) {
	if (!is_numeric($alias)) {
		$attr = $alias;
	}

	if ($item->has_attr($attr)) {
		$def = System\Model\Database::get_attr($model, $attr);

		if ($def[0] != 'password' && !in_array($attr, $banned_attrs) && !in_array($attr, $attrs_edit_exclude) && !\System\Model\Database::is_model_belongs_to_id($model, $attr)) {
			$attrs[] = $attr;
		}
	}
}

$f = new System\Form(array(
	"default" => $item->get_data(),
	"heading" => $heading,
));

foreach ($attrs as $attr) {
	$def = System\Model\Database::get_attr($model, $attr);
	$required = !(isset($def['is_null']) || isset($def['default']));

	if (in_array($def[0], array('date', 'datetime', 'time', 'image', 'location'))) {
		$type = $def[0];
	} elseif ($def[0] === 'point') {
		$type = 'gps';
	} elseif ($def[0] === 'bool') {
		$type = 'checkbox';
		$required = false;
	} elseif ($def[0] === 'text') {
		$type = 'textarea';
	} else {
		$type = 'text';
	}

	if (in_array($attr, array('created_at', 'updated_at'))) {
		$name = l($attr);
	} else {
		$name = System\Model\Attr::get_model_attr_name($model, $attr);
	}

	$f->input(array(
		"type"  => $type,
		"name"  => $attr,
		"label" => $name,
		"required" => $required,
	));
}

$f->submit(l('godmode_save'));

if ($f->passed()) {
	$p = $f->get_data();
	$item->update_attrs($p);
	$item->save();
	redirect(soprintf($link_redir, $item));

} else {
	$f->out($this);
}
