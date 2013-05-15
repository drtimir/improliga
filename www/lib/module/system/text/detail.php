<?

def($id);
def($show_heading, true);
def($template, 'system/text/detail');

if ($id && $item = find('\System\Text', $id)) {
	$this->partial($template, array(
		"text" => $item,
		"show_heading" => true,
	));
} else throw new \System\Error\NotFound(t('system_text_not_found', $id));
