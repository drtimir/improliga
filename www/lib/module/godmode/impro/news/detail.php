<?

def($id);
def($template, 'godmode/impro/news/detail');
def($link_cont, '/god/impro/news/{id_impro_news}/');
def($link_author, '/god/users/{id_author}/');

if ($id && $item = find("\Impro\News", $id)) {
	$this->template($template, array(
		"item" => $item,
		"link_cont" => $link_cont,
		"link_author" => $link_author,
	));
}
