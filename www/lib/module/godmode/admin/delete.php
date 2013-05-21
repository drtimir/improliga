<?

$this->req('id');
$this->req('model');
$this->req('link_god');

$model = System\Loader::get_class_from_model($model);

def($heading, t('godmode_delete_object', strtolower(System\Loader::get_model_from_class($model))));
def($attrs_detail);


if ($item = find($model, $id)) {
	$attrs = array();
	$x = 0;

	if (empty($attrs_detail)) {
		$attrs_detail = System\Model\Database::get_model_attr_list($model);
	}

	foreach ($attrs_detail as $attr) {
		if ($item->has_attr($attr)) {
			$def = System\Model\Database::get_attr($model, $attr);

			if ($def[0] != 'password') {
				$attrs[] = $attr;
			}
		} else {
			$attrs[] = $attr;
		}
	}

	foreach ($attrs as $attr) {
		if ($attr == System\Model\Database::get_id_col($model)) {
			$name = l('Id');
		} elseif (in_array($attr, array('created_at', 'updated_at'))) {
			$name = l($attr);
		} else {
			$name = System\Model\Attr::get_model_attr_name($model, $attr);
		}

		$info[$name] = System\Template::to_html($item->$attr);
	}


	$f = $ren->form_checker(array(
		"heading" => $heading,
		"info" => $info,
		"class" => 'admin-delete',
	));


	if ($f->passed()) {
		$item->drop();
		$flow->redirect(\Godmode\Router::url($request, $link_god, 'list'));
	} else {
		$f->out($this);
	}
} else throw new System\Error\NotFound();
