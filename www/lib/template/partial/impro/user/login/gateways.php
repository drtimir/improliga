<?

echo div('login-gateways');

	echo $ren->heading($locales->trans('user_login_via_gateway'));
	echo p($locales->trans('user_login_via_gateway_desc'), 'desc');
	echo p('Seznam sítí budeme postupně a v dlouhých intervalech rozšiřovat.', 'desc');

	echo ul('plain', array(
		li($ren->icon_for_url('login_facebook', 'impro/social/facebook', 32, array(
			"title" => $locales->trans('user_login_via_facebook'),
		))),
	));


close('div');
