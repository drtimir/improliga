<?

$this->req('id');
$this->req('model');
$this->req('link_god');

def($heading, '');
def($conds, array());
def($opts, array());
def($attrs_detail);
def($template, 'godmode/admin/detail');

$model = System\Loader::get_class_from_model($model);
if ($item  = find($model, $id)) {
	$attrs = array();

	if (empty($attrs_detail)) {
		$attrs_detail = System\Model\Database::get_model_attrs($model, false);
	}

	$idc = \System\Model\Database::get_id_col($model);
	$attrs[$idc] = $idc;


	foreach ($attrs_detail as $attr=>$def) {
		if ($item->has_attr($attr)) {

			if ($def[0] != 'password' && strpos($attr, 'id') !== 0) {
				$attrs[] = $attr;
			}

		} else {
			$attrs[] = $attr;
		}
	}

	$this->partial($template, array(
		"item"     => $item,
		"heading"  => $heading,
		"link_god" => $link_god,
		"attrs"    => $attrs,
		"model"    => $model,
	));
} else throw new \System\Error\NotFound();
