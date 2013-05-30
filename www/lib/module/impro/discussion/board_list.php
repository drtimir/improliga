<?

def($conds, array());
def($template, 'impro/discussion/board_list');
def($heading, $locales->trans('impro_discussion_board_list'));

$board_sql = get_all('\Impro\Discussion\Board')->where($conds);
$count  = $board_sql->count();
$boards = $board_sql->sort_by('created_at DESC')->paginate($per_page, $page)->fetch();

$this->partial($template, array(
	"count"   => $count,
	"boards"  => $boards,
	"heading" => $heading,
));
