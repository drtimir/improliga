<?

echo div('working');

	echo p($locales->trans('intra_warning_working'));

	echo div('small');
		$ren->slot('working-desc');
	close('div');
close('div');
