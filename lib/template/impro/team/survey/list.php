<?

echo div('survey-list');

	echo $ren->heading($locales->trans('impro_team_survey_list'));

	if (any($surveys)) {
		echo ul('plain');

			foreach ($surveys as $survey) {
				echo li();
					$ren->render_partial('impro/team/survey/detail', array(
						"survey"  => $survey,
						"answers" => $survey->answers->fetch(),
					));
				close('li');
			}

		close('ul');
	} else {
		echo p($locales->trans('impro_team_survey_none'));
	}

close('div');
