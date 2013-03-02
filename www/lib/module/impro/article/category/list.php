<?

def($heading, l('impro_article_list'));
def($conds, array("visible" => true));
def($template, "impro/article/category/list");
def($link_article, "/o-improlize/{seoname}");

$categories = get_all('Impro\Article\Category')->where($conds)->fetch();

$this->template($template, array(
	"heading"      => $heading,
	"categories"   => $categories,
	"link_article" => $link_article,
));
