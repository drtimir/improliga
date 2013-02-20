<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

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

	$f = new System\Form(array(
		"class"   => 'event_wizzard',
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard"),
		"desc"    => t('impro_event_wizzard_step_participants'),
		"default" => $part,
	));


	if ($event->id_impro_event_type === Impro\Event\Type::ID_MATCH) {
		$sides = array('home', 'away');

		if (!$event->id_team_home || !$event->id_team_away) {
			redirect_now(stprintf($link_wizzard, array('step' => Impro\Event::ID_WIZZARD_STEP_TEAMS)));
		}
	} else {
		$sides = array('home');

		if (!$event->id_team_home) {
			redirect_now(stprintf($link_wizzard, array('step' => Impro\Event::ID_WIZZARD_STEP_TEAMS)));
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
				"label"    => l('impro_event_players_'.$side.($event->id_impro_event_type === Impro\Event\Type::ID_MATCH ? '':'_owner')),
				"options"  => $players[$side],
				"multiple" => true,
			));
		}
	}

	$f->text('hint0', l('impro_event_wizzard_participants_players_hint'));
	$f->submit(l('impro_event_wizzard_next'));
	$f->input_submit('cancel', l('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("step" => 'cancel')));
		} else {
			$part = array();
			if ($event->id_impro_event_type === Impro\Event\Type::ID_MATCH) {
				$part[Impro\Event\Participant\Type::ID_PLAYER_HOME] = (array) $p['players_home'];
				$part[Impro\Event\Participant\Type::ID_PLAYER_AWAY] = (array) $p['players_away'];
			}

			$event->assign($part);
			$event->update_attrs($p)->save();
			redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_TOOLS)));
		}
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_PARTICIPANTS;
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

