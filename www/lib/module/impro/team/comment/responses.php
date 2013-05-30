<?

$this->req('id_comment');

def($template, 'impro/team/comment/responses');

if ($id_comment && ($comment = find('\Impro\Team\Comment', $id_comment))) {

	$responses = $comment->responses->sort_by('created_at')->fetch();

	$this->partial($template, array(
		"comment"   => $comment,
		"responses" => $responses,
	));

	$module->propagate('comment', $comment);

} else throw new \System\Error\NotFound();
