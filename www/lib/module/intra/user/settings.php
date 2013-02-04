<?

def($redirect, '/settings/');
$user = user();

$f = new System\Form(array(
	"heading" => l('user_settings'),
	"default" => $user->get_data(),
	"action"  => $redirect,
));

	$f->input_text('first_name', l('godmode_user_first_name'), true);
	$f->input_text('last_name', l('godmode_user_last_name'), true);
	$f->input_text('nick', l('godmode_nick'));
	$f->input(array(
		"type"  => 'image',
		"name"  => 'avatar',
		"label" => l('user_avatar'),
	));

	$f->submit(l('save'));

	if ($f->passed()) {
		$p = $f->get_data();
		$user->update_attrs($p)->save();
		redirect($redirect);
	}

$f->out($this);
