<?

def($id_team);
def($conds, array("visible" => true));
def($template, 'impro/team/comment/list');

if ((any($propagated['team']) && $team = $propagated['team']) || ($id_team && ($team = find('\Impro\Team', $id_team)))) {

	$comments = $team->comments
		->add_cols(array("response_count" => '(SELECT COUNT(*) FROM `impro_team_comment_response` where `id_comment` = t0.id_impro_team_comment)'))
		->where($conds)
		->sort_by('updated_at DESC')
		->paginate($per_page, $page)
		->fetch();

	$module->partial($template, array(
		"team"         => $team,
		"comments"     => $comments,
	));

} else throw new \System\Error\NotFound();
