<?

def($id);
def($self, false);
def($template, 'impro/user/profile');
def($link_team, '/teams/{seoname}/');
def($link_event, '/events/{seoname}/');



if (($self && $user = user()) || ($id && $user = find('\System\User', $id))) {

	$member_of = get_all('\Impro\Team\Member')->where(array("id_system_user" => $user->id))->fetch();
	$event_conds = array(
		array(
			"id_author" => $user->id,
		),
		//~ "visible" => true
	);

	$participants = get_all('\Impro\Event\Participant')->where(array('id_impro_event_participant IN ('.implode(',', collect_ids($member_of)).')'))->fetch();

	if (any($participants)) {
		$event_conds[0][] = "id_impro_event IN (".implode(',', collect(array('attr', 'id_impro_event'), $participants)).')';
	}

	$events = get_all('\Impro\Event')->where($event_conds)->paginate(5)->fetch();


	$this->template($template, array(
		"user"      => $user,
		"member_of" => $member_of,
		"link_team" => $link_team,
		"link_event" => $link_event,
		"contacts"  => $user->contacts->where(array("visible" => true))->fetch(),
		"events"    => $events,
	));
} else throw new \System\Error\NotFound();
