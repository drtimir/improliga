<?

$this->req('rqid');

if ($propagated['user'] && $propagated['code']) {
	if ($rqid && ($rq = find('\Impro\User\Request', $rqid))) {

		$user = &$propagated['user'];
		$code = &$propagated['code'];

		if ($rq->id_user == $user->id) {

			$f = $ren->form(array(
				"heading" => l('intra_user_request_heading'),
				"class"   => 'request',
				"default" => array(
					"yes" => 1,
					"no" => 1,
					"maybe" => 1,
				),
			));

			$f->hidden('submited', true);
			$f->text('label', $rq->text);
			$f->text('desc', l('intra_user_request_desc'));

			$f->input(array("name" => 'yes', "label" => ucfirsts(l('yes')), "type" => 'submit', "kind" => 'button'));
			$f->input(array("name" => 'no', "label" => ucfirsts(l('no')), "type" => 'submit', "kind" => 'button'));

			if ($rq->allow_maybe) {
				$f->input(array(
					"name"  => 'maybe',
					"label" => ucfirsts(l('maybe')),
					"type"  => 'submit',
					"kind"  => 'button',
				));
			}

			if ($f->passed()) {
				$p = $f->get_data();

				$value = null;

				if (isset($p['yes'])) $value = \Impro\User\Request::RESPONSE_YES;
				if (isset($p['no'])) $value = \Impro\User\Request::RESPONSE_NO;
				if (isset($p['maybe'])) $value = \Impro\User\Request::RESPONSE_MAYBE;

				$rq->callback($value);
				$rq->mail_response($ren);
				$rq->redirect();

			} else $f->out($this);

		} else throw new \System\AccessDenied();
	} else throw new \System\NotFound();
} else throw new \System\AccessDenied();
