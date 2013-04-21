<?

$this->req('id');

def($booking,      false);
def($link_cont,    '/udalosti/{seoname}/');
def($link_book,    '/udalosti/{seoname}/rezervace/');
def($link_day,     '/udalosti/seznam/{year}-{month}/#'.l('day').'{day}');
def($link_team,    '/teams/{seoname}/');
def($link_team_menu, '/teams/{seoname}/%s/');
def($link_month,   '/udalosti/seznam/{year}-{month}/');
def($thumb_width,  100);
def($thumb_height, 100);
def($template,     'intra/team/detail_head');
def($slot_events, 'events');

if ($team = find('Impro\Team', $id)) {

	System\Output::set_title($team->name.' - '.$team->name_full);

	$start = new DateTime();
	$event_count = get_all('\Impro\Event')->where(array(
		"published" => true,
		"visible"   => true,
		array(
			"id_team_home" => $team->id,
			"id_team_away" => $team->id,
		),
	))->count();


	$this->template($template, array(
		"member" => $team->member(),
		"team"   => $team,
		"link_team" => $link_team,
		"link_team_menu" => soprintf($link_team_menu, $team),
	));

	$propagate['team'] = $team;
}
