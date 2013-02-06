<?

def($id_board);
def($conds, array("visible" => true));
def($template, 'impro/discussion/topic_list');
def($heading, l('impro_discussion_topic_list'));
def($link_board, '/discussion/{id_impro_discussion_board}/');
def($link_topic, '/discussion/{id_board}/{id_impro_discussion_topic}/');
def($link_topic_create, '/discussion/{id_impro_discussion_board}/create_topic/');

if ($board = find('\Impro\Discussion\Board', $id_board)) {

	System\Output::set_title($board->name);
	$topic_sql = $board->topics->where($conds);
	$count  = $topic_sql->count();
	$topics = $topic_sql->sort_by('created_at DESC')->paginate($per_page, 0)->fetch();

	$this->template($template, array(
		"count"   => $count,
		"board"   => $board,
		"topics"  => $topics,
		"heading" => $heading,

		"link_board" => $link_board,
		"link_topic" => $link_topic,
		"link_topic_create" => $link_topic_create,
	));

}
