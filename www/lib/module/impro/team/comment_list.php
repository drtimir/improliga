<?

$this->req('id_team');

def($conds, array("visible" => true));
def($template, 'impro/team/comment_list');
def($link_user, '/profile/{seoname}/');
def($link_team, '/teams/{seoname}/');


if ($id_team && ($team = find('\Impro\Team', $id))) {

	$comments = $team->comments->where($conds)->paginate($per_page, $page)->fetch();

	$this->template($template, array(
		"team"     => $team,
		"comments" => $comments,
		"link_user" => $link_user,
		"link_team" => $link_team,
	));

} else throw new \System\Error\NotFound();
