<?

def($id_topic);
def($id_board);
def($heading, $locales->trans('impro_discussion_post_create'));

def($board);
def($topic);

$id_board && ($board = find('\Impro\Discussion\Board', $id_board));
$id_topic && ($topic = find('\Impro\Discussion\Topic', $id_topic));

if ($board && $topic) {
	$item = new Impro\Discussion\Post();
	$item->id_board = $board->id;
	$item->id_topic = $topic->id;
	$item->visible  = true;

	$f = $ren->form(array(
		"default" => $item->get_data(),
	));

	$f->input_rte('text', $locales->trans('impro_discussion_post_text'), true);
	$f->submit($heading);

	if ($f->passed()) {
		$p = $f->get_data();
		$item->id_author = $request->user()->id;
		$item->update_attrs($p)->save();

		$flow->redirect($ren->url('discussion_topic', array($board, $topic)));

	} else {
		$f->out($this);
	}
} else throw new \System\Error\NotFound();
