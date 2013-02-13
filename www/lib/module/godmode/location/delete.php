<?

def($id);
def($link_cont, '/god/locations/');
def($heading, l('godmode_static_text_delete'));

if($id && $item = find("\System\Location", $id)){

	$ed = System\Form::create_delete_checker(array(
		"submit" => l('godmode_delete'),
		"heading" => $heading,
		"info" => array(
			l('godmode_name')    => $item->name,
			l('godmode_address') => $item->addr,
		),
	));

	if ($ed->passed()) {

		$item->drop() ?
			message('success', $heading, l('godmode_delete_success')):
			message('error', $heading, l('godmode_delete_fail'));

		redirect(soprintf($link_cont, $item));

	} else $ed->out($this);
} else $this->error('params');
