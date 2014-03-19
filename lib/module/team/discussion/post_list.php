<?

$this->req('id');

def($conds, array("visible" => true));
def($template, 'impro/team/discussion/post_list');
def($heading, $locales->trans('impro_discussion_post_list'));

if ((any($propagated['team']) && $team = $propagated['team']) && ($topic = find('\Impro\Team\Discussion\Topic', $id))) {

	$ren->title = $topic->name;
	$post_sql = $topic->posts->where($conds);
	$count = $post_sql->count();
	$posts = $post_sql->sort_by('created_at DESC')->paginate($per_page, 0)->fetch();

	$this->partial($template, array(
		"member"  => $member,
		"count"   => $count,
		"topic"   => $topic,
		"posts"   => $posts,
		"heading" => $heading,
	));

	$this->propagate('topic', $topic);
} else throw new \System\Error\NotFound();

