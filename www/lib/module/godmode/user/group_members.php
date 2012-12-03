<?

def($page, 0);
def($per_page, 20);
def($link_cont, '/god/users/{id_user}');
def($show_heading, true);

$group = find("\System\User\Group", $group_id);
$users = $group->users->paginate($per_page, $page)->fetch();

$this->template('godmode/item-list', array(
	"cols" => array(
		array('login', l('godmode_user_login'), 'link'),
		array('get_name', l('godmode_user_name'), 'function'),
		array('updated_at', l('godmode_last_lgoin'), 'date'),
		array('created_at', l('godmode_created_at'), 'date'),
		array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
	),
	"items"     => $users,
	"link_cont" => $link_cont,
	"heading"   => $show_heading ? sprintf(def($heading, l('List users of group "%s"')), $group->name):null,
));
