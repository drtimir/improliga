<?

def($link_cont, '/impro/news/{id_impro_news}/');
def($conds, array());
def($opts, array());
def($show_heading, true);
def($heading, l('impro_news_list'));

$news = get_all("\Impro\News", $conds, $opts)->paginate($per_page, $page)->fetch();
$count = count_all("\Impro\News", $conds, $opts);

$this->template("impro/news/list", array(
	"news"  => $news,
	"count" => $count,
));
