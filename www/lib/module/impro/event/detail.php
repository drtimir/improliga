<?

def($id);
def($link_cont, '/events/{id_impro_event}/');
def($link_team, '/teams/{id_impro_team}/');
def($conds, array());
def($opts, array());
def($template, 'impro/event/detail');

if ($id && $item = find('\Impro\Event', $id)) {

	title($item->title);

	$this->template($template, array(
		"event" => $item,
		"link_cont" => $link_cont,
		"link_team" => $link_team,
	));

} else throw new System\Error\NotFound();
