<?

def($template, "impro/team/list");
def($conds, array("visible" => true));
def($link_team, 'public_team_detail');

$query = get_all('Impro\Team')->where($conds);
$items = $query->sort_by('name')->fetch();
$count = $query->count();
$cities = array();

foreach ($items as $team) {
	if (!isset($cities[$team->city])) {
		$cities[$team->city] = array();
	}

	$cities[$team->city][] = $team;
}

ksort($cities);

$this->partial($template, array(
	"cities"     => $cities,
	"count"     => $count,
	"link_team" => $link_team,
));
