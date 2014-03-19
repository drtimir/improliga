<?

def($booking, false);
def($heading, false);
def($template, 'impro/event/list_latest');
def($thumb_width,  100);
def($thumb_height, 100);

if (isset($propagated['team'])) {

	$team = $propagated['team'];

	$start = new DateTime();
	$events = get_all('\Impro\Event')->where(array(
		"published" => true,
		"visible"   => true,
		array(
			"id_team_home" => $team->id,
			"id_team_away" => $team->id,
		),
	))->sort_by('start desc')->fetch();


	$this->partial($template, array(
		"events"       => $events,
		"start"        => $start,
		"heading"      => $heading,
		"booking"      => $booking,
		"thumb_width"  => $thumb_width,
		"thumb_height" => $thumb_height,
		"show_desc"    => false,
	));

} else throw new \System\Error\NotFound();
