<?

def($new, false);
def($id);
def($redirect, '/god/impro/news/{id_impro_news}/');

if (($new && $item = new Impro\News()) || ($id && $item = find("\Impro\News", $id))) {

	$heading = $new ? l('impro_news_create'):l('impro_news_edit');
	$f = new System\Form(array(
		"default" => $item->get_data(),
		"heading" => $heading,
	));

	$f->input_text('title', l('impro_news_title'), true);
	$f->input_textarea('text', l('impro_news_text'), true);
	$f->input_checkbox('visible', l('godmode_visible'));
	$f->input_checkbox('published', l('godmode_published'));

	$f->submit(l('godmode_save'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (!$item->id_author) {
			$item->id_author = user()->id;
		}

		$item->update_attrs($p)->save();

		if (!$item->errors()) {
			message('success', $heading, l('godmode_save_success'), true);
			redirect(soprintf($redirect, $item));
		} else message('error', $heading, l('godmode_save_error'), true);
	} else {
		$f->out($this);
	}
} else $this->error('params');
