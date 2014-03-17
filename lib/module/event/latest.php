<?

def($template, 'event/list/latest');
def($conds, array("visible" => true, "public" => true));
def($heading, $locales->trans('impro_events_latest'));
def($booking, false);
def($show_desc, true);
def($thumb_width, 100);
def($thumb_height, 100);
def($per_page, 5);

$start = new DateTime();
$conds[] = "t0.start >= '".$locales->format_date($start, 'sql', 0)."'";
$items = get_all("\Impro\Event")->where($conds)->sort_by('start')->paginate($per_page, $page)->fetch();

$this->partial($template, array(
	"events"       => $items,
	"start"        => $start,
	"heading"      => $heading,
	"booking"      => $booking,
	"show_desc"    => $show_desc,
	"thumb_width"  => $thumb_width,
	"thumb_height" => $thumb_height,
	"controls"     => false,
));
