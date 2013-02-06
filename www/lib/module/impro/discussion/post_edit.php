<?

def($id);
def($id_topic);
def($id_board);
def($new, false);
def($heading, l($new ? 'impro_discussion_topic_create':'impro_discussion_topic_edit'));
def($redirect, '/discussion/{id_board}/{id_topic}/');

def($board);
def($topic);

$id_board && ($board = find('\Impro\Discussion\Board', $id_board));
$id_topic && ($topic = find('\Impro\Discussion\Topic', $id_topic));

if (($id && $item = find('\Impro\Discussion\Post', $id)) || ($new && $item = new Impro\Discussion\Post())) {

	$item->id_board = $id_board;
	$item->id_topic = $id_topic;
	$item->visible  = true;

	$f = new System\Form(array(
		"default" => $item->get_data(),
		"heading" => $heading,
		"action"  => intra_path(),
	));

	$f->input_textarea('text', l('impro_discussion_post_text'), true);
	$f->submit($heading);

	if ($f->passed()) {
		$p = $f->get_data();
		$item->update_attrs($p)->save();

		redirect(soprintf($redirect, $item));

	} else {
		$f->out($this);
	}
}

