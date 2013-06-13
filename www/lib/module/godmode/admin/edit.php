<?

$this->req('model');
$this->req('link_god');

def($id);
def($new, false);

$model = System\Loader::get_class_from_model($model);
$heading_default = $locales->trans($new ? 'godmode_create_object':'godmode_edit_object', strtolower($locales->trans_class_name($model)));


if ($item = $new ? (new $model()):find($model, $id)) {

	$ed = Godmode\Editor::for_object($ren, $item, array(
		"heading"            => def($heading, $heading_default),
		"desc"               => def($desc, ''),
		"picker"             => def($rel_pick, array()),
		"manager"            => def($rel_tab, array()),
		"attrs_edit"         => def($attrs_edit, array()),
		"attrs_edit_exclude" => def($attrs_edit_exclude, array()),
	));

	if ($ed->passed() && $ed->save()) {
		$p = $ed->f()->get_data();

		if (!empty($p['save_and_edit'])) {
			$flow->redirect(\Godmode\Router::url($request, $link_god, 'edit', array($item->id)));
		} else if (!empty($p['save_and_add'])) {
			$flow->redirect(\Godmode\Router::url($request, $link_god, 'create'));
		} else {
			$flow->redirect(\Godmode\Router::url($request, $link_god, 'detail', array($item->id)));
		}
	}

	$ed->f()->out($this);

} else throw new \System\Error\NotFound();
