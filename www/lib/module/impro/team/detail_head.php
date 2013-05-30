<?

$this->req('id');

def($booking,      false);
def($thumb_width,  100);
def($thumb_height, 100);
def($template,     'impro/team/detail_head');
def($slot_events, 'events');

if ($team = find('Impro\Team', $id)) {

	$ren->title = $team->name.' - '.$team->name_full;

	$start = new DateTime();
	$event_count = get_all('\Impro\Event')->where(array(
		"published" => true,
		"visible"   => true,
		array(
			"id_team_home" => $team->id,
			"id_team_away" => $team->id,
		),
	))->count();


	$module->partial($template, array(
		"member" => $team->member($request->user()),
		"team"   => $team,
	));

	$module->propagate('team', $team);
}

