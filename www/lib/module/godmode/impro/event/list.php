<?

def($link_cont, '/god/impro/events/{id_impro_event}/');
def($conds, array());
def($opts, array());
def($per_page, 20);
def($page, 0);
def($heading, l('impro_event_list'));

$items = get_all("\Impro\Event", $conds, $opts)->paginate($per_page, $page)->fetch();
$count = count_all("\Impro\Event", $conds, $opts);

$this->template('godmode/item-list', array(
	"cols" => array(
		array('title',      l('impro_event_name'), 'link', $link_cont),
		array('start',      l('impro_event_start'), 'date'),
		array('visible',    l('godmode_visible'), 'bool'),
		array('published',  l('godmode_published'), 'bool'),
		array('updated_at', l('godmode_updated_at'), 'date'),
		array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
	),
	"items"     => $items,
	"link_cont" => $link_cont,
	"heading"   => def($show_heading, true) ? $heading:null,
));

