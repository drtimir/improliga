<?

def($id_team);
def($conds, array("visible" => true));
def($template, 'impro/team/comment/list');

if ((any($propagated['team']) && $team = $propagated['team']) || ($id_team && ($team = find('\Impro\Team', $id_team)))) {

	$comments = $team->posts
		->add_cols(array("response_count" => '(SELECT COUNT(*) FROM `impro_post` where `id_parent` = t0.id_impro_post)'))
		->where($conds)
		->sort_by('updated_at DESC')
		->paginate($per_page, $page)
		->fetch();

	$module->partial($template, array(
		"team"         => $team,
		"comments"     => $comments,
	));

} else throw new \System\Error\NotFound();
