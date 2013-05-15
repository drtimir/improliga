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
$item  = find($model, $id);
$attrs = array();

if (empty($attrs_detail)) {
	$attrs_detail = System\Model\Database::get_model_attr_list($model, false);
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

$this->partial($template, array(
	"item"     => $item,
	"heading"  => $heading,
	"link_god" => $link_god,
	"attrs"    => $attrs,
	"model"    => $model,
));
