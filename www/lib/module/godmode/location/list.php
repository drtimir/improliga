<?

def($link_cont, '/god/locations/{id_system_location}/');
def($conds, array());
def($opts, array());
def($show_heading, true);
def($heading, l('godmode_location_list'));

$items = get_all("\System\Location", $conds, $opts)->paginate($per_page, $page)->fetch();
$count = count_all("\System\Location", $conds, $opts);

$this->template('godmode/item-list', array(
	"cols" => array(
		array('name',    l('godmode_name'), 'link', $link_cont),
		array('addr', l('godmode_address')),
		array('created_at', l('godmode_created_at'), 'date'),
		array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
	),
	"items"     => $items,
	"link_cont" => $link_cont,
	"heading"   => $show_heading ? $heading:null,
	"count"     => $count,
));
