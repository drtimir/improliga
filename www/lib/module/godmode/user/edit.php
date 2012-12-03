<?

def($new, false);
def($id);
def($redirect, '/god/users/{id_system_user}/edit/');

if (($new && $user = new System\User()) || ($id && $user = find("\System\User", $id))) {

	$dd = $user->get_data();
	$heading = $new ? l('godmode_user_create'):l('godmode_user_edit');

	$f = new System\Form(array(
		"default" => $dd,
		"id" => 'edit-user',
		"heading" => $heading,
	));

	$f->input_text('first_name', l('godmode_user_first_name'), true);
	$f->input_text('last_name', l('godmode_user_last_name'), true);
	$f->input_text('login', l('godmode_user_login'), true);
	$f->input_text('nick', l('godmode_nick'));

	if ($new) {
		$f->input(array("name" => 'password', "label" => l('godmode_password'), "type" => 'password'));
	}

	$f->submit(l('godmode_save'));

	if ($f->passed()) {

		$p = $f->get_data();
		def($p['password'], System\User::gen_passwd());
		def($p['nick'], $p['login']);

		$match = count_all("\System\User", array("login" => $p['login']));

		if ($match) {
			$matched = get_first("\System\User", array("login" => $p['login']))->fetch();
			$match = $matched->id != $user->id;
		}

		if (!$match) {
			$user->update_attrs($p)->save();

			if (!$user->errors()) {
				message('success', $heading, _('Uživatel byl úspěšně uložen'), true);
				redirect(soprintf($redirect, $user));
			}
		} else {
			$this->error('login-exists');
		}
	}

	if (!$f->passed() || $user->errors()) {
		if ($user->errors()) {
			message('error', $heading, System\Locales::sysmsg($user->errors()));
		}

		$f->out($this);
	}

} else $this->error('params');
