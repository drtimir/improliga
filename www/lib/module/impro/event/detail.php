<?

def($id);
def($link_cont, '/events/{id_impro_event}/');
def($link_action, '/events/{id_impro_event}/{action}');
def($link_team, '/teams/{id_impro_team}/');
def($conds, array());
def($opts, array());
def($template, 'impro/event/detail');
def($col_width, 270);

if ($id && $item = find('\Impro\Event', $id)) {

	title($item->title);
	$controls = user()->id == $item->id_author || user()->has_right('edit_events');
	System\Output::set_title($item->name);

	$this->template($template, array(
		"event"       => $item,
		"link_cont"   => $link_cont,
		"link_team"   => $link_team,
		"link_action" => $link_action,
		"col_width"   => $col_width,
		"controls"    => $controls,
	));

} else throw new System\Error\NotFound();
