<?

$this->req('model');
$this->req('link_redir');

$model = System\Loader::get_class_from_model($model);

def($id);
def($rel_inline, array());
def($rel_pick, array());
def($new, false);
def($desc, '');
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
$inline_has_many = array();

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

$default = $item->get_data();

foreach ($rel_pick as $key=>$rel) {
	if (System\Model\Database::attr_is_rel($model, $rel)) {
		$default[$rel] = collect_ids($item->$rel->fetch());
	} else throw new System\Error\Format(sprintf('Cannot use picker for "%s". It is not an attribute', $rel));
}



$f = new System\Form(array("default" => $default, "heading" => $heading, "desc" => $desc));

if (any($rel_inline) || any($rel_pick)) {
	$f->tab(l('godmode_model_basic_attrs'));
}

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

foreach ($rel_pick as $rel) {
	$f->tab(System\Model\Attr::get_model_attr_name($model, $rel));

	$type = \System\Model\Database::get_rel_type($model, $rel);
	$def  = \System\Model\Database::get_rel_def($model, $rel);

	$models = get_all($def['model'])->fetch();

	if ($type == 'has-many') {
		$in = $f->input(array(
			"type"     => 'checkbox',
			"options"  => $models,
			"name"     => $rel,
			"multiple" => true,
			"label"    => System\Model\Attr::get_model_attr_name($model, $rel),
		));
	}
}

$f->tab_group_end();
$f->submit(l('godmode_save'));

if ($f->passed()) {
	$p = $f->get_data();

	$rel_data = array();
	$item->update_attrs($p);
	$item->save();

	foreach ($rel_pick as $rel) {

		$type = \System\Model\Database::get_rel_type($model, $rel);
		if ($type == 'has-many') {
			if (is_array($p[$rel])) {
				$item->assign_rel($rel, $p[$rel]);
			} else {
				$item->assign_rel($rel, array());
			}
		}
	}

	redirect(soprintf($link_redir, $item));

} else {
	$f->out($this);
}
