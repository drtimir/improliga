<?

def($heading, $locales->trans('impro_article_list'));
def($conds, array("visible" => true));
def($template, "article/category/list");

$categories = get_all('Impro\Article\Category')->where($conds)->fetch();

$this->partial($template, array(
	"heading"    => $heading,
	"categories" => $categories
));
