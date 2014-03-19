<?

def($template, "team/list");
def($conds, array("visible" => true));
def($ts, array(118, 100));

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
	"cities"    => $cities,
	"count"     => $count,
	"ts"        => $ts,
));
