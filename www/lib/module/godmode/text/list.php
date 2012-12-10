<?

def($link_cont, '/god/texts/{id_system_text}/');
def($conds, array());
def($opts, array());
def($per_page, 20);
def($page, 0);
def($heading, l('godmode_static_text_list'));

$texts = get_all("\System\Text", $conds, $opts)->paginate($per_page, $page)->fetch();
$count = count_all("\System\Text", $conds, $opts);

$this->template('godmode/item-list', array(
	"cols" => array(
		array('name',    l('godmode_name'), 'link', $link_cont),
		array('visible', l('godmode_visible'), 'bool'),
		array('updated_at', l('godmode_last_login'), 'date'),
		array('created_at', l('godmode_created_at'), 'date'),
		array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
	),
	"items"     => $texts,
	"link_cont" => $link_cont,
	"heading"   => def($show_heading, true) ? $heading:null,
));
