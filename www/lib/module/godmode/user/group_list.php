<?

def($conds, array());
def($opts, array());
def($per_page, 20);
def($page, 0);
def($heading, l('godmode_user_group_list'));
def($desc, l('godmode_user_group_desc'));
def($link_cont, '/god/users/groups/{id_system_user_group}/');

$groups = get_all("\System\User\Group", $conds, $opts)->paginate($per_page, $page)->fetch();

$this->template(def($template, 'godmode/item-list'), array(
	"items"     => $groups,
	"heading"   => $heading,
	"desc"      => $desc,
	"link_cont" => $link_cont,
	"cols"      => array(
		array('name', l('godmode_name'), 'link', $link_cont),
		array('count_users', l('godmode_user_count'), 'function'),
		array('updated_at', l('godmode_updated_at'), 'date'),
		array('created_at', l('godmode_created_at'), 'date'),
		array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
	),

));
