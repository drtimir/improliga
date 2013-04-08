<?

$this->req('id_comment');

def($template, 'impro/team/comment_responses');
def($link_respond, '/teams/{seoname}/respond/{id_impro_team_comment}/');
def($link_response, '/teams/{seoname}/respond/{id_comment}/#post_{id_impro_team_comment_response}');


if ($id_comment && ($comment = find('\Impro\Team\Comment', $id_comment))) {

	$responses = $comment->responses->sort_by('created_at')->fetch();

	$this->template($template, array(
		"comment"   => $comment,
		"responses" => $responses,

		"link_respond" => soprintf($link_respond, $team),
		"link_response" => soprintf($link_response, $team),
	));

	$propagate['comment'] = $comment;

} else throw new \System\Error\NotFound();
