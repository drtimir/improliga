<?

$this->req('id');

def($booking,      false);
def($thumb_width,  100);
def($thumb_height, 100);
def($template,     'impro/team/detail');
def($template_events, 'impro/event/list_latest');
def($slot_events, 'events');

if ($team = find('Impro\Team', $id)) {

	$response->renderer()->title = $locales->trans('title_impro_team', $team->name);

	$start = new DateTime();
	$events = get_all('\Impro\Event')->where(array(
		"published" => true,
		"visible"   => true,
		array(
			"id_team_home" => $team->id,
			"id_team_away" => $team->id,
		),
	))->sort_by('start desc')->fetch();


	$this->partial($template, array("team" => $team));
	$this->partial($template_events, array(
		"slot"         => $slot_events,
		"events"       => $events,
		"start"        => $start,
		"heading"      => false,
		"booking"      => $booking,
		"thumb_width"  => $thumb_width,
		"thumb_height" => $thumb_height,
		"show_desc"    => false,
	));
}
