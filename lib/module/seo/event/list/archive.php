<?

def($template, 'seo/event/list/archive');
def($conds, array("published" => true));
def($per_page, 20);

$start = new DateTime();

$query = get_all("Impro\Event")
	->where($conds)
	->sort_by('start DESC, start_time DESC')
	->paginate($per_page, $page);

$total = $query->count();
$items = $query->fetch();

$this->partial($template, array(
	'events'   => $items,
	'per_page' => $per_page,
	'page'     => $page,
	'total'    => $total
));
