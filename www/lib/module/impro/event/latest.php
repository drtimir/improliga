<?

def($template, '/impro/event/list_latest');
def($conds, array("visible" => true, "public" => true));
def($heading, l('impro_events_latest'));
def($booking, false);
def($link_cont, '/god/impro/events/{id_impro_event}/');
def($link_book, '/');
def($link_month, '/events/list/{year}-{month}/');
def($link_day, '/events/list/{year}-{month}/#day_{day}');
def($link_team, '/team/{id_impro_team}/');
def($per_page, 5);

$start = new DateTime();
$conds[] = "t0.start >= '".format_date($start, 'sql')."'";
$items = get_all("\Impro\Event")->where($conds)->sort_by('start')->paginate($per_page, $page)->fetch();

$this->template($template, array(
	"events"     => $items,
	"start"      => $start,
	"heading"    => $heading,
	"booking"    => $booking,
	"link_cont"  => $link_cont,
	"link_book"  => $link_book,
	"link_day"   => $link_day,
	"link_team"  => $link_team,
	"link_month" => $link_month,
));
