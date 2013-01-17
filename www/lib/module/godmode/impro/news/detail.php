<?

def($id);
def($redirect, '/god/impro/news/{id_impro_news}/');

if ($id && $item = find("\Impro\News", $id)) {
	$this->template('godmode/impro/news/detail', array(
		"item" => $item,
	));
}
