<?

def($link_cont, '/god/users/perms/{path}/');
def($heading, l("godmode_user_perms_list"));

$mods = \System\Module::get_all(false);
$this->template("godmode/user/perm_list", array(
	"mods"      => $mods,
	"link_cont" => $link_cont,
	"heading"   => $heading,
));
