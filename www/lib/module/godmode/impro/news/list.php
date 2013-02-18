<?

def($link_cont, '/god/impro/news/{id_impro_news}/');
def($conds, array());
def($opts, array());
def($show_heading, true);
def($heading, l('impro_news_list'));

$users = get_all("\Impro\News", $conds, $opts)->paginate($per_page, $page)->fetch();
$count = count_all("\Impro\News", $conds, $opts);

$this->template('godmode/item-list', array(
	"cols" => array(
		array('name', l('impro_news_title'), 'link', $link_cont),
		array('visible', l('godmode_visible'), 'bool'),
		array('published', l('godmode_published'), 'bool'),
		array('updated_at', l('godmode_updated_at'), 'date'),
		array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
	),
	"items"     => $users,
	"count"     => $count,
	"link_cont" => $link_cont,
	"heading"   => $show_heading ? $heading:null,
));
