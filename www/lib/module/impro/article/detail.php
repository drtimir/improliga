<?

$this->req('id');

def($template, 'impro/article/detail');
def($conds, array("visible" => true));

if ($article = find('Impro\Article', $id)) {

	$this->template($template, array(
		"article"  => $article,
		"chapters" => $article->chapters->where($conds)->fetch(),
	));

} else throw new System\Error\NotFound();
