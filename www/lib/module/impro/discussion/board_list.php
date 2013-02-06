<?

def($conds, array());
def($template, 'impro/discussion/board_list');
def($heading, l('impro_discussion_board_list'));
def($link_board, '/discussion/{id_impro_discussion_board}/');
def($link_topic, '/discussion/{id_board}/{id_impro_discussion_topic}/');

$board_sql = get_all('\Impro\Discussion\Board')->where($conds);
$count  = $board_sql->count();
$boards = $board_sql->sort_by('created_at DESC')->paginate($per_page, $page)->fetch();

$this->template($template, array(
	"count"   => $count,
	"boards"  => $boards,
	"heading" => $heading,

	"link_board" => $link_board,
	"link_topic" => $link_topic,
));
