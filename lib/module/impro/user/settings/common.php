<?

$user    = $request->user();
$default = $user->get_data();
$ug      = $user->get_group_ids();

$groups = array(
	'musician'     => 5,
	'conferencier' => 6,
	'referee'      => 7,
);


foreach ($groups as $group=>$gid) {
	if (in_array($gid, $ug)) {
		$default[$group] = true;
	}
}


$f = $ren->form(array(
	"class"   => 'usercfg',
	"heading" => $locales->trans('user_settings_basic'),
	"default" => $default,
));

	$f->input_text('first_name', $locales->trans('godmode_user_first_name'), true);

	if ($request->get('message')) {
		$f->text('msg', $ren->trans('user_msg_fill_name'));
	}

	$f->input_text('last_name', $locales->trans('godmode_user_last_name'), true);
	$f->input_text('nick', $locales->trans('godmode_nick'));
	$f->input(array(
		"type"  => 'image',
		"name"  => 'avatar',
		"label" => $locales->trans('impro_user_avatar'),
	));

	$f->text('msg_check', $locales->trans('user_checkbox_desc'));
	$f->input_checkbox('musician', $locales->trans('user_musician'));
	$f->input_checkbox('conferencier', $locales->trans('user_conferencier'));
	$f->input_checkbox('referee', $locales->trans('user_referee'));

	$f->submit($locales->trans('save'));

	if ($f->passed()) {
		$p = $f->get_data();
		$user->update_attrs($p);

		foreach ($groups as $group=>$gid) {
			if (isset($p[$group])) {
				if (!in_array($gid, $ug)) {
					$ug[] = $gid;
				}
			} else {
				if (in_array($gid, $ug)) {
					foreach ($ug as $k=>$g) {
						if ($g == $gid) {
							unset($ug[$k]);
							break;
						}
					}
				}
			}
		}

		$user->groups = $ug;
		$user->save();

		$flow->redirect($ren->url('profile_settings'));
	}

$f->out($this);
