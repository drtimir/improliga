<?

$user = $request->user();

$ed = Godmode\Editor::for_object($ren, $user, array(
	"manager"            => array('contacts'),
	"attrs_edit"         => array(),
	"extra_buttons"      => false,
	"attrs_edit_exclude" => array('first_name', 'last_name', 'login', 'nick', 'avatar', 'last_login'),
));

$ed->f()->class = 'usercontacts relman';
$ed->f()->out($this);


if ($ed->passed() && $ed->save()) {
	$flow->redirect($ren->url('profile_settings_contacts'));
}
