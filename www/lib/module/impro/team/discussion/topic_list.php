<?

def($id_board);
def($conds, array("visible" => true));
def($template, 'impro/team/discussion/topic_list');
def($heading, $locales->trans('impro_discussion_topic_list'));

if ($team = $propagated['team']) {

	$topic_sql = $team->topics->where($conds);
	$count  = $topic_sql->count();
	$topics = $topic_sql->sort_by('created_at DESC')->paginate($per_page, 0)->fetch();

	$this->partial($template, array(
		"member"  => $propagated['member'],
		"count"   => $count,
		"topics"  => $topics,
		"heading" => $heading,
	));

} else throw new \System\Error\NotFound();
