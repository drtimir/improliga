<?

def($step);

if ($step && file_exists($p = ROOT.System\Module::BASE_DIR.'/impro/event/wizzard/'.$step.'.php')) {
	require_once $p;
} else throw new System\Error\NotFound('Event wizzard step was not found.');
