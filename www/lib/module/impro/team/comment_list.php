<?

def($id_team);
def($conds, array("visible" => true));
def($template, 'impro/team/comment_list');
def($link_user, '/profile/{seoname}/');
def($link_team, '/teams/{seoname}/');
def($link_respond, '/teams/{seoname}/respond/{id_impro_team_comment}/');
def($link_response, '/teams/{seoname}/respond/{id_comment}/#post_{id_impro_team_comment_response}');

if ((any($propagated['team']) && $team = $propagated['team']) || ($id_team && ($team = find('\Impro\Team', $id_team)))) {

	$comments = $team->comments
		->add_cols(array("response_count" => '(SELECT COUNT(*) FROM `impro_team_comment_response` where `id_comment` = t0.id_impro_team_comment)'))
		->where($conds)
		->sort_by('updated_at DESC')
		->paginate($per_page, $page)
		->fetch();

	$this->template($template, array(
		"team"         => $team,
		"comments"     => $comments,
		"link_user"    => $link_user,
		"link_team"    => $link_team,
		"link_respond" => soprintf($link_respond, $team),
		"link_response" => soprintf($link_response, $team),
	));

} else throw new \System\Error\NotFound();
