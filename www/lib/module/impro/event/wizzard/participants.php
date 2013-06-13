<?

def($id);
def($new, false);

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$event_participants = $event->participants->fetch();
	$part = array();

	$roles = array(
		Impro\Event\Participant\Type::ID_PLAYER => 'players_home',
		Impro\Event\Participant\Type::ID_PLAYER_HOME => 'players_home',
		Impro\Event\Participant\Type::ID_PLAYER_AWAY => 'players_away',
	);

	foreach ($event_participants as $participant) {
		if (!isset($part[$participant->type])) {
			$part[$roles[$participant->type]] = array();
		}

		$part[$roles[$participant->type]][] = $participant->id_impro_team_member;
	}

	$f = $ren->form(array(
		"class"   => 'event_wizzard',
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_participants'),
		"default" => $part,
	));


	if ($event->type === Impro\Event\Type::ID_MATCH) {
		$sides = array('home', 'away');

		if (!$event->id_team_home || !$event->id_team_away) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, 'step' => Impro\Event::ID_WIZZARD_STEP_TEAMS)));
		}
	} else {
		$sides = array('home');

		if (!$event->id_team_home) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, 'step' => Impro\Event::ID_WIZZARD_STEP_TEAMS)));
		}
	}


	$players = array();

	foreach ($sides as $side) {
		$players[$side] = array();
		$var = 'team_'.$side;
		$players_temp = $event->$var->members->fetch();

		foreach ($players_temp as $p) {
			$players[$side][$p->id] = $p->user->get_name();
		}

		if (any($players[$side])) {
			$f->input(array(
				"type"     => 'checkbox',
				"name"     => 'players_'.$side,
				"label"    => $locales->trans('impro_event_players_'.$side.($event->type === Impro\Event\Type::ID_MATCH ? '':'_owner')),
				"options"  => $players[$side],
				"multiple" => true,
			));
		}
	}

	$f->text('hint0', $locales->trans('impro_event_wizzard_participants_players_hint'));
	$f->submit($locales->trans('impro_event_wizzard_next'));
	$f->input_submit('cancel', $locales->trans('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, "step" => Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$part = array();
			if ($event->type === Impro\Event\Type::ID_MATCH) {
				isset($p['players_home']) && $part[Impro\Event\Participant\Type::ID_PLAYER_HOME] = (array) $p['players_home'];
				isset($p['players_away']) && $part[Impro\Event\Participant\Type::ID_PLAYER_AWAY] = (array) $p['players_away'];
			}

			$event->assign($part);
			$event->update_attrs($p)->save();
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_TOOLS)));
		}
	} else {
		$f->out($this);
	}

	$this->propagate('event', $event);
	$this->propagate('wizzard_step', Impro\Event::ID_WIZZARD_STEP_PARTICIPANTS);
} else throw new System\Error\AccessDenied();

