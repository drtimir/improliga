<?

def($id);
def($show_heading, true);
def($template, 'system/text/detail');

if ($id && $item = find('\System\Text', $id)) {
	$this->template($template, array(
		"text" => $item,
		"show_heading" => true,
	));
} else throw new \System\NotFound(t('system_text_not_found', $id));
