<?

def($id);
def($id_board);
def($conds, array("visible" => true));
def($template, 'impro/discussion/post_list');
def($heading, $locales->trans('impro_discussion_post_list'));

if (($board = find('\Impro\Discussion\Board', $id_board)) && $topic = find('\Impro\Discussion\Topic', $id)) {

	$ren->title = $topic->name;
	$post_sql = $topic->posts->where($conds);
	$count = $post_sql->count();
	$posts = $post_sql->sort_by('created_at DESC')->paginate($per_page, 0)->fetch();

	$this->partial($template, array(
		"count"   => $count,
		"board"   => $board,
		"topic"   => $topic,
		"posts"   => $posts,
		"heading" => $heading,
	));
}

