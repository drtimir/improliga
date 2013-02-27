<?

$this->req('id');
$this->req('model');
$this->req('link_redir');

$model = System\Loader::get_class_from_model($model);

def($heading, t('godmode_delete_object', strtolower(System\Model\Attr::get_model_model_name($model))));
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
		$info[$attr] = System\Template::to_html($item->$attr);
	}


	$f = System\Form::create_delete_checker(array(
		"heading" => $heading,
		"info" => $info,
	));


	if ($f->passed()) {
		$item->drop();
		redirect(soprintf($link_redir, $item));
	} else {
		$f->out($this);
	}
} else throw new System\Error\NotFound();
