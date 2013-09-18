<?

$sur_count = $survey->votes->count();
$sur_voted = $survey->voted($request->user);

echo div('survey');
	echo ul('plain survey-answers');

		foreach ($answers as $ans) {
			echo li(null, 'answer');
				$width = $sur_count ? round($ans->vote_count/$sur_count*100):0;

				if (!$sur_voted || ($survey->multi && !$ans->voted($request->user))) {
					echo $ren->link_for('team_survey_vote', $ans->name, args($survey->id, $ans->id));
				} else {
					echo span('answer', $ans->name);
				}

				echo span('votes', $ans->vote_count);
				echo span('progressbar', \Tag::span(array(
					'class' => 'progress' . ($ans->color ? '':' progress-default'),
					'style' => 'width:'.$width.'%;' .($ans->color ? ' background-color:'.get_css_color($ans->color):''),
				)));
			close('li');
		}

	close('ul');

	echo span('text', $locales->trans('impro_team_survey_votes', $sur_count));

close('div');

