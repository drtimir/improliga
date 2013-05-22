<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');
def($template, 'impro/event/wizzard');
def($event);

if (any($propagated['event'])) {
	$event = &$propagated['event'];
	$current  = $propagated['wizzard_step'];
} else {
	$current = null;
}

if ($event || ($event = Impro\Event::wizzard_for($request->user(), $id, $new))) {

	$this->partial($template, array(
		"event" => $event,
		"steps" => Impro\Event::get_wizzard_steps(),
		"current" => $current,
		"link_wizzard" => $link_wizzard,
	));

} else throw new System\Error\AccessDenied();
