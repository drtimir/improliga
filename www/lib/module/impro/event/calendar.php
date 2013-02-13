<?

def($mode, 'month-grid');
def($year, date("Y"));
def($month, intval(date("m")));
def($shift, '');
def($cont_link, '/god/impro/events/{id_impro_event}/');
def($day_link, '/events/list/{year}-{month}/#day_{day}');
def($day_link_integrate, false);
def($template, '/impro/event/calendar');
def($book_link, '/');
def($conds, array("visible" => true));
def($heading, l('impro_event_calendar'));
def($day, intval(date("d")));
def($link_team, '/team/{id_impro_team}/');

$day = $mode == 'month-grid' ? 1:$day;

any($propagated['day']) && $day = $propagated['day'];
any($propagated['month']) && $month = $propagated['month'];
any($propagated['year']) && $year = $propagated['year'];

$start_time = mktime(0, 0, 0, $month, $day, $year);
$start = new DateTime();
$start->setTimestamp($start_time);

if ($shift) {
	$start->modify($shift);
	$month = intval($start->format('m'));
	$year  = intval($start->format('Y'));
}

$end = clone $start;
$end->modify("+1 month");

$conds[] = "t0.start >= '".format_date($start, 'sql')."'";
$conds[] = "t0.start <= '".format_date($end, 'sql')."'";

$items = get_all("\Impro\Event")->where($conds)->sort_by('start')->fetch();
$events = array_fill(1, 31, array());

foreach ($items as &$item) {
	$estart = clone $item->start;
	$dur = $item->all_day ? 86399:$item->duration;

	if ($item->duration) {
		while ($dur > 0) {
			$events[intval($estart->format('d'))][] = &$item;
			$estart->modify("+ 1 day");
			$dur -= 86400;
		}
	} else {
		$events[intval($estart->format('d'))][] = &$item;
	}
}

$this->template($template, array(
	"events"    => $events,
	"year"      => $year,
	"month"     => $month,
	"day"       => $day,
	"start"     => $start,
	"end"       => $end,
	"first"     => $start->format('w'),
	"mode"      => $mode,
	"heading"   => $heading,
	"booking"   => true,
	"day_link"  => $day_link,
	"book_link" => $book_link,
	"cont_link" => $cont_link,
	"day_link_integrate" => $day_link_integrate,
	"link_team" => $link_team,
));

$propagate['cal-events'] = &$events;
$propagate['events'] = &$items;
