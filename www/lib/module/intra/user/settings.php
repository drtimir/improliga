<?

$user = $request->user();

$f = $ren->form(array(
	"heading" => l('impro_user_settings'),
	"default" => $user->get_data(),
));

	$f->tab('Základní');

		$f->input_text('first_name', l('godmode_user_first_name'), true);
		$f->input_text('last_name', l('godmode_user_last_name'), true);
		$f->input_text('nick', l('godmode_nick'));
		$f->input(array(
			"type"  => 'image',
			"name"  => 'avatar',
			"label" => l('impro_user_avatar'),
		));

	$f->tab('Kontakty');
	$f->tab_group_end();

	$f->submit(l('save'));

	if ($f->passed()) {
		$p = $f->get_data();
		$user->update_attrs($p)->save();
		$flow->redirect($ren->url('profile_settings'));
	}

$f->out($this);
