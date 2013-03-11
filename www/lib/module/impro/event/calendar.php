<?

if (def($month_input)) {
	list($year, $month) = array_map('intval', explode('-', $month_input));
}

def($mode, 'month-grid');
def($year, date("Y"));
def($month, intval(date("m")));
def($shift, '');
def($day_link_integrate, false);
def($day_names_short, false);
def($template, '/impro/event/calendar');
def($conds, array("visible" => true));
def($heading, l('impro_event_calendar'));
def($day, intval(date("d")));
def($link_book, '/');
def($link_cont, '/god/impro/events/{id_impro_event}/');
def($link_day, '/events/list/{year}-{month}/#day_{day}');
def($link_day_piece, 'day_{day}');
def($link_team, '/team/{id_impro_team}/');
def($link_month, '/events/list/{year}-{month}/');

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
	$dur = $item->duration();

	if ($item->duration) {
		while ($dur > 0) {
			$events[intval($estart->format('d'))][] = &$item;
			$estart->modify("+ 1 day");
		}
	} else {
		$events[intval($estart->format('d'))][] = &$item;
	}
}

$nm = clone $start;
$nm->modify("+1 month");

$pm = clone $start;
$pm->modify("-1 month");

$months = System\Locales::get('date:months');
title(t('impro_event_list_for_month', $months[$month]));

$this->template($template, array(
	"events"     => $events,
	"year"       => $year,
	"month"      => $month,
	"day"        => $day,
	"start"      => $start,
	"end"        => $end,
	"first"      => $start->format('w'),
	"mode"       => $mode,
	"heading"    => $heading,
	"booking"    => true,
	"prev"       => $pm,
	"next"       => $nm,
	"day_link_integrate" => $day_link_integrate,
	"day_names_short" => $day_names_short,
	"link_day"   => $link_day,
	"link_day_piece"   => $link_day_piece,
	"link_book"  => $link_book,
	"link_cont"  => $link_cont,
	"link_team"  => $link_team,
	"link_month" => $link_month,
	"controls"   => false,
));

$propagate['cal-events'] = &$events;
$propagate['events'] = &$items;
