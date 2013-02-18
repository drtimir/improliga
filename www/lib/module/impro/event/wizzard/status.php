<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');
def($template, 'impro/event/wizzard');

if (any($propagated['event'])) {
	$event = &$propagated['event'];
	$current  = $propagated['wizzard_step'];
} else {
	$current = null;
}

if ($event || ($event = Impro\Event::wizzard_for($id, $new))) {

	$this->template($template, array(
		"event" => $event,
		"steps" => Impro\Event::get_wizzard_steps(),
		"current" => $current,
		"link_wizzard" => $link_wizzard,
	));

} else throw new System\Error\AccessDenied();

//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

