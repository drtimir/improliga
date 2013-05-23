<?

def($id_board);
def($conds, array("visible" => true));
def($template, 'impro/discussion/topic_list');
def($heading, l('impro_discussion_topic_list'));

if ($board = find('\Impro\Discussion\Board', $id_board)) {

	$ren->title = $board->name;
	$topic_sql = $board->topics->where($conds);
	$count  = $topic_sql->count();
	$topics = $topic_sql->sort_by('created_at DESC')->paginate($per_page, 0)->fetch();

	$this->partial($template, array(
		"count"   => $count,
		"board"   => $board,
		"topics"  => $topics,
		"heading" => $heading,
	));

}
