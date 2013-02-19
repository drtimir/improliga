<?

def($template, '/impro/event/list_latest');
def($conds, array());
def($heading, l('impro_events_my'));
def($booking, false);
def($link_cont, '/events/{id_impro_event}/');
def($link_book, '/');
def($link_month, '/events/list/{year}-{month}/');
def($link_day, '/events/list/{year}-{month}/#day_{day}');
def($link_team, '/team/{id_impro_team}/');

$conds['id_author'] = user()->id;
$items = get_all("\Impro\Event")->where($conds)->sort_by('start')->paginate($per_page, $page)->fetch();

$this->template($template, array(
	"events"     => $items,
	"heading"    => $heading,
	"booking"    => $booking,
	"link_cont"  => $link_cont,
	"link_book"  => $link_book,
	"link_day"   => $link_day,
	"link_team"  => $link_team,
	"link_month" => $link_month,
	"controls"   => true,
));
