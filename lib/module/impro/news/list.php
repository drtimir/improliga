<?

def($conds, array("visible" => true));
def($opts, array());
def($show_heading, true);
def($heading, $locales->trans('impro_news_list'));
def($per_page, 3);
def($display_author, false);

if (any($propagated['news'])) {
	$conds[] = 'id_impro_news NOT IN ('.implode(array_map('intval', (array) $propagated['news'])).')';
}

$news = get_all("\Impro\News", $conds, $opts)->sort_by('created_at DESC')->paginate($per_page, $page)->fetch();
$count = count_all("\Impro\News", $conds, $opts);


$module->partial("impro/news/list", array(
	"news"  => $news,
	"count" => $count,
	"display_author" => $display_author,
));

