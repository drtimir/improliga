<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$part = array();

	foreach ($event->participants as $part) {
	}

	$f = new System\Form(array(
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard", l('impro_event_wizzard_step_participants')),
		"default" => $part,
	));

	if ($event->id_impro_event_type === Impro\Event\Type::ID_MATCH) {
		$sides = array('home', 'away');
	} else {
		$sides = array('home');
	}

	$players = array();

	foreach ($sides as $side) {
		$players[$side] = array();
		$var = 'team_'.$side;
		$players_temp = $event->$var->members->fetch();

		foreach ($players_temp as $p) {
			$players[$side][$p->id] = $p->user->get_name();
		}

		$f->input(array(
			"type"     => 'checkbox',
			"name"     => 'players_'.$side,
			"label"    => l('impro_event_players_'.$side),
			"options"  => $players[$side],
			"multiple" => true,
		));
	}

	$f->submit(l('impro_event_wizzard_next'));

	if ($f->passed()) {
		$p = $f->get_data();
		$event->update_attrs($p)->save();
		redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_TOOLS)));
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

