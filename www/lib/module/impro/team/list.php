<?

def($template, "impro/team/list");
def($conds, array("visible" => true));
def($link_team, '/tymy/{seoname}');

$query = get_all('Impro\Team')->where($conds);
$items = $query->paginate($per_page, $page)->sort_by('name')->fetch();
$count = $query->count();

$this->template($template, array(
	"teams"     => $items,
	"count"     => $count,
	"link_team" => $link_team,
));
