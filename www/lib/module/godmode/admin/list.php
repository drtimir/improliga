<?

$this->req('model');
$this->req('attrs_list');
$this->req('link_god');

$model = System\Loader::get_class_from_model($model);

def($heading, $locales->trans('godmode_item_list'));
def($desc, '');
def($conds, array());
def($opts, array());
def($template, 'godmode/admin/list');
def($sort, array('created_at desc'));


foreach ($sort as &$sort_item) {
	$sort_item = str_replace('id', \System\Model\Database::get_id_col($model), $sort_item);
}


$query = get_all($model, $conds, $opts);
$items = $query->paginate($per_page, $page)->sort_by(implode(', ', $sort))->fetch();
$count = $query->count();

$cols = array();
$x = 0;


foreach ($attrs_list as $attr) {

	if (System\Model\Database::attr_exists($model, $attr)) {
		$def = System\Model\Database::get_attr($model, $attr);

		if (in_array($def[0], array('int', 'float'))) {
			$type = 'number';
		} elseif (in_array($def[0], array('date', 'datetime', 'time'))) {
			$type = 'date';
		} else {
			$type = 'string';
		}

		if (in_array($attr, array('created_at', 'updated_at'))) {
			$name = $locales->trans($attr);
		} else {
			$name = $locales->trans_model_attr_name($model, $attr);
		}

		$col = array($attr, $name, $type);

	} elseif (method_exists($model, $attr)) {
		$col = array($attr, $locales->trans_model_attr_name($model, $attr), 'function');
	}

	if (any($col)) {
		if ($x === 0) {
			$col[2] = 'link-'.$col[2];
			$col[3] = $link_god;
		}

		$cols[] = $col;
		$x++;
	}
}


$cols[] = array(null, null, 'actions', array($locales->trans('godmode_edit') => 'edit', $locales->trans('godmode_delete') => 'delete'));

$this->partial($template, array(
	"cols"      => $cols,
	"items"     => $items,
	"heading"   => $heading,
	"desc"      => $desc,
	"count"     => $count,
	"link_god"  => $link_god,
));
