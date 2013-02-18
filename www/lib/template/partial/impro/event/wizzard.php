<?

Tag::div(array("class" => 'wizzard'));

	echo section_heading(l('impro_event_wizzard_status'));

	Tag::ul(array("class" => 'plain'));
		$passed = true;
		$complete = true;

		foreach ($steps as $step=>$label) {
			$class = array();
			$complete = true;

			if ($step !== Impro\Event::ID_WIZZARD_STEP_NAME && (!$event->id_impro_event_type || !$event->name)) {
				$passed = false;
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_TEAMS) {
				$complete = $event->id_impro_event_type === Impro\Event\Type::ID_MATCH ? ($event->id_team_home && $event->id_team_away):($event->id_team_home);
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_TOOLS) {
				$complete = $event->has_all_tools();
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_POSTER) {
				$complete = $event->image && $event->image->file_name;
			}

			if ($step === Impro\Event::ID_WIZZARD_STEP_PUBLISH) {
				$passed = false;
			}

			if ($passed && $current !== $step) {
				$content = link_for($label, stprintf($link_wizzard, array("step" => $step)));
			} else {
				$content = $label;
			}

			!$complete && $class[] = 'incomplete';
			$class[] = $passed ? 'passed':'failed';

			if ($current === $step) {
				$class[] = 'current';
			}

			Tag::li(array(
				"class"   => $class,
				"content" => $content,
			));
		}

	Tag::close('ul');
Tag::close('div');
