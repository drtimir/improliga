<?

$this->req('model');
$this->req('link_redir');

$model = System\Loader::get_class_from_model($model);

def($id);
def($rel_inline, array());
def($rel_pick, array());
def($rel_tab, array());
def($new, false);
def($desc, '');
def($heading, t($new ? 'godmode_create_object':'godmode_edit_object', strtolower(System\Loader::get_class_trans($model))));
def($attrs_edit, array());
def($attrs_edit_exclude, array());

$item  = $new ? (new $model()):find($model, $id);
$attrs = array();
$x = 0;

if (empty($attrs_edit)) {
	$attrs_edit = System\Model\Database::get_model_attr_list($model);
	$attrs_edit = array_merge($attrs_edit, System\Model\Database::get_location_attrs($model));
}

$banned_attrs = array(System\Model\Database::get_id_col($model), 'created_at', 'updated_at');
$inline_has_many = array();
$rel_data = array();
$rels = array();

foreach ($attrs_edit as $alias=>$attr) {
	if (!is_numeric($alias)) {
		$attr = $alias;
	}

	if ($item->has_attr($attr)) {
		$def = System\Model\Database::get_attr($model, $attr);

		if ($def[0] != 'password' && !in_array($attr, $banned_attrs) && !in_array($attr, $attrs_edit_exclude) && !\System\Model\Database::is_model_belongs_to_id($model, $attr)) {
			$attrs[$attr] = $def;
			$attrs[$attr]['type'] = 'attr';
		}
	} elseif (\System\Model\Database::get_rel_type($model, $attr) === 'belongs-to') {
		$def = \System\Model\Database::get_rel_def($model, $attr);
		if (\System\Loader::get_link_from_class($def['model']) === 'system_location') {
			$attrs[$attr] = $def;
			$attrs[$attr]['type'] = 'belongs-to';
		}
	}
}

$default = $item->get_data();

foreach ($rel_pick as $rel) {
	if (System\Model\Database::attr_is_rel($model, $rel)) {
		$default[$rel] = collect_ids($item->$rel->fetch());
		$rels[$rel] = 'pick';
	} else throw new System\Error\Format(sprintf('Cannot use picker for "%s". It is not model relation of any kind.', $rel));
}

foreach ($rel_tab as $rel) {
	if (System\Model\Database::attr_is_rel($model, $rel)) {
		$rel_data[$rel] = $item->$rel->fetch();
		$rels[$rel] = 'manage';
	} else throw new System\Error\Format(sprintf('Cannot manage "%s" in tabs. It is not model relation of any kind.', $rel));
}


$f = new System\Form(array("default" => $default, "heading" => $heading, "desc" => $desc));

if (any($rel_inline) || any($rel_pick)) {
	$f->tab(l('godmode_model_basic_attrs'));
}

foreach ($attrs as $attr=>$def) {
	$required = !(isset($def['is_null']) || isset($def['default']));

	if ($def['type'] === 'attr') {
		$type = \System\Form::get_field_type($def[0]);

		if ($def[0] === 'bool') {
			$required = false;
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
	} else {
		$link = \System\Loader::get_link_from_class($def['model']);

		if ($link === 'system_location') {
			$f->input_location($attr, System\Model\Attr::get_model_attr_name($model, $attr));
		} else {
			if (empty($all[$link])) {
				$all[$link] = get_all($def['model'])->fetch();
			}

			$f->input(array(
				"type" => 'select',
				"name" => \System\Model\Database::get_attr_name_from_belongs_to_rel($attr, $def),
				"options" => $all[$link],
				"label"   => System\Model\Attr::get_model_attr_name($model, $attr),
			));
		}
	}
}

foreach ($rel_tab as $rel) {
	$f->tab(System\Model\Attr::get_model_attr_name($model, $rel));
	Godmode\Form::add_rel_edit($f, $model, $rel, $rel_data[$rel]);
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

	/* Relation name => Relation edit method */
	foreach ($rels as $rel=>$expect) {
		$type = \System\Model\Database::get_rel_type($model, $rel);
		$def  = \System\Model\Database::get_rel_def($model, $rel);

		if ($expect === 'pick') {
			if ($type == 'has-many') {
				if (is_array($p[$rel])) {
					$ids = $p[$rel];
				} else $ids = array();
			}
		} elseif ($expect === 'manage') {
			if ($type == 'has-many') {
				$ids = array();

				if (is_array($p[$rel])) {
					$rel_target_def = \System\Model\Database::get_rel_bound_to_def($model, $rel);
					$attr_target = \System\Model\Database::get_attr_name_from_belongs_to_rel($rel_target_def['name'], $rel_target_def);

					if (isset($p[$rel]['add'])) {
						foreach ($p[$rel]['add'] as $data) {
							$empty = true;

							foreach ($data as $at=>$data_attr) {
								if (any($data_attr)) {
									$empty = false;
									break;
								}
							}

							if (!$empty) {
								$data[$attr_target] = $item->id;
								$obj = create($def['model'], $data);
								$ids[] = $obj->id;
							}
						}
					}

					unset($p[$rel]['add']);
				}

				foreach ($p[$rel] as $id=>$data) {
					$obj = find($def['model'], $id);
					$obj->update_attrs($data);

					if ($obj->delete) {
						$obj->drop();
					} else {
						$obj->$attr_target = $item->id;
						$obj->save();
						$ids[] = $obj->id;
					}
				}

				$ids = array_filter($ids);
			}
		}

		if (any($def['is_bilinear'])) {
			$item->assign_rel($rel, $ids);
		}
	}

	redirect(stprintf($link_redir, $item->get_data()));

} else {
	$f->out($this);
}
