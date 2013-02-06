<?

def($id);
def($id_board);
def($conds, array("visible" => true));
def($template, 'impro/discussion/post_list');
def($heading, l('impro_discussion_post_list'));
def($link_board, '/discussion/{id_board}/');
def($link_topic, '/discussion/{id_board}/{id_impro_discussion_topic}/');
def($link_topic_create, '/discussion/{id_impro_discussion_board}/create_topic/');
def($link_post_create, '/discussion/{id_board}/{id_impro_discussion_topic}/create_post/');

if (($board = find('\Impro\Discussion\Board', $id_board)) && $topic = find('\Impro\Discussion\Topic', $id)) {

	System\Output::set_title($topic->name);
	$post_sql = $topic->posts->where($conds);
	$count = $post_sql->count();
	$posts = $post_sql->sort_by('created_at DESC')->paginate($per_page, 0)->fetch();

	$this->template($template, array(
		"count"   => $count,
		"board"   => $board,
		"topic"   => $topic,
		"posts"   => $posts,
		"heading" => $heading,

		"link_board" => $link_board,
		"link_topic" => $link_topic,
		"link_topic_create" => $link_topic_create,
		"link_post_create"  => $link_post_create,
	));
}

