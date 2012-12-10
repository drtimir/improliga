<?

def($id);
def($link_cont, '/god/texts/');
def($heading, l('godmode_static_text_delete'));

if($id && $group = find("\System\Text", $id)){

	$ed = System\Form::create_delete_checker(array(
		"submit" => l('godmode_delete'),
		"heading" => $heading,
		"info" => array(
			l('godmode_name') => $group->name,
		),
	));

	if ($ed->passed()) {

		$group->drop() ?
			message('success', $heading, l('godmode_delete_success')):
			message('error', $heading, l('godmode_delete_fail'));

		redirect(soprintf($link_cont, $group));

	} else $ed->out($this);
} else $this->error('params');
