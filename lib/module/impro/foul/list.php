<?

def($template, 'impro/foul/list');
def($link_foul, '/o-improlize/fauly/{seoname}/');
def($conds, array(
	"visible" => true,
));


$items = get_all('\Impro\Foul')->where($conds)->fetch();
$this->template($template, array(
	"items"     => $items,
	"link_foul" => $link_foul,
));
