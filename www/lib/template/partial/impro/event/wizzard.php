<?

$ren->content_for('title', 'Úprava události ('.$event->name.') - Improliga');

echo div('wizzard');

	echo $ren->heading(l('impro_event_wizzard_status'));

	echo ul('plain');
		$passed = true;
		$complete = true;
		$prev = false;

		foreach ($steps as $step=>$label) {
			$class = array();
			$complete = true;

			if ($step === Impro\Event::ID_WIZZARD_STEP_NAME) {
				$passed = $event->type && $event->name;
			}

			if ($step !== Impro\Event::ID_WIZZARD_STEP_NAME && (!$event->type || !$event->name)) {
				$passed = false;
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_TEAMS) {
				$passed = $event->type === Impro\Event\Type::ID_MATCH ? ($event->id_team_home && $event->id_team_away):($event->id_team_home);
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_TOOLS) {
				$complete = $event->has_all_tools();
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_POSTER) {
				$complete = $event->image && $event->image->file_name;
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_PARTICIPANTS) {
				$complete = $event->participants->count() > 0;
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_PUBLISH) {
				$complete = $event->type === Impro\Event\Type::ID_MATCH ? ($event->id_team_home && $event->id_team_away):($event->id_team_home);
				$complete = $complete && $event->has_all_tools();
				$complete = $complete && $event->image && $event->image->file_name;
				//~ $passed = false;
			}

			if (($current !== $step && ($passed || $prev)) || $step == Impro\Event::ID_WIZZARD_STEP_NAME) {
				$content = $ren->link_for('event_edit_step', $label, array("args" => array($event, $step)));
			} else {
				$content = $label;
			}

			!$complete && $class[] = 'incomplete';
			$class[] = $passed ? 'passed':'failed';

			if ($current === $step) {
				$class[] = 'current';
			}

			$prev = $passed;

			echo li($content, $class);
		}

	close('ul');
close('div');
