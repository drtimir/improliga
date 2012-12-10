<?

def($link_cont, '/god/impro/teams/{id_impro_team}/');
def($conds, array());
def($opts, array());
def($per_page, 20);
def($page, 0);
def($heading, l('impro_team_list'));

$users = get_all("\Impro\Team", $conds, $opts)->paginate($per_page, $page)->fetch();
$count = count_all("\Impro\Team", $conds, $opts);

$this->template('godmode/item-list', array(
	"cols" => array(
		array('name',          l('impro_team_name'), 'link', $link_cont),
		array('name_full',     l('impro_team_name_full')),
		array('count_players', l('impro_team_players'), 'function'),
		array('visible',       l('godmode_visible'), 'bool'),
		array('created_at', l('godmode_created_at'), 'date'),
		array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
	),
	"items"     => $users,
	"link_cont" => $link_cont,
	"heading"   => def($show_heading, true) ? $heading:null,
));

