<?

namespace Impro\User
{
	class Alert extends \System\Model\Perm
	{
		const TYPE_NOTICE    = 1;
		const TYPE_REQUEST   = 2;

		const TEMPLATE_NOTICE          = 1;
		const TEMPLATE_REQUEST         = 2;
		const TEMPLATE_INVITE_TEAM     = 3;
		const TEMPLATE_INVITE_TRAINING = 4;

		const RESPONSE_YES   = 1;
		const RESPONSE_NO    = 2;
		const RESPONSE_MAYBE = 3;

		protected static $attrs = array(
			"user"         => array('belongs_to', "model" => 'System\User'),
			"text"         => array('text'),
			"read"         => array('bool'),

			"type"         => array('int', "options" => array(
				self::TYPE_NOTICE  => 'notice',
				self::TYPE_REQUEST => 'request',
			)),

			"template"     => array('int', "options" => array(
				self::TEMPLATE_NOTICE          => 'common-notice',
				self::TEMPLATE_REQUEST         => 'common-request',
				self::TEMPLATE_INVITE_TEAM     => 'invite-team',
				self::TEMPLATE_INVITE_TRAINING => 'invite-training',
			)),

			"response"     => array('int', "is_null" => true, "options" => array(
				self::RESPONSE_YES    => 'yes',
				self::RESPONSE_NO     => 'no',
				self::RESPONSE_MAYBE  => 'maybe',
			)),

			"generated_by"   => array('varchar'),

			"code"           => array('belongs_to', "model" => 'System\User\Auth\Code'),
			"user"           => array('belongs_to', "model" => 'System\User'),
			"author"         => array('belongs_to', "model" => 'System\User'),
			"event"          => array('belongs_to', "model" => 'Impro\Event', "is_null" => true),
			"team"           => array('belongs_to', "model" => 'Impro\Team', "is_null" => true),
			"member"         => array('belongs_to', "model" => 'Impro\Team\Member', "is_null" => true),
			"training"       => array('belongs_to', "model" => 'Impro\Team\Training', "is_null" => true),

			"allow_maybe"  => array('bool'),
		);


		public function gen_code()
		{
			$this->code = \System\User\Auth\Code::generate($user);
			return $this;
		}


		public function get_template()
		{
			return self::get_model_attr_options($this, 'template')[$this->template]
		}


		public function get_mail_from_template()
		{
			$template = $this->get_template();
			$subject  = 'mail-subject-'.$template;
			$body     = 'mail-body-'.$template;
			$locales  = new \System\Locales();
			$locales->set_locale();

			$subject = stprintf($locales()->trans($subject), $this->get_data());
			$body    = stprintf($locales()->trans($bidy), $this->get_data());

			$mail = \System\Offcom\Mail::create($subject, $body);

			return $mail;
		}


		public function mail()
		{
			$conds = array(
				"type" => \System\User\Contact::STD_EMAIL,
				"spam" => true,
			);

			$contacts = $this->user->contacts->where($conds)->fetch();
			$mail = $this->get_mail_from_template();

			$contacts_author = $this->author->contacts->where(array(
				"type" => \System\User\Contact::STD_EMAIL, "public" => true,
				))->fetch();

			$cs_rcpt   = collect(array('attr', 'ident'), $contacts, true);
			$cs_author = collect(array('attr', 'ident'), $contacts_author, true);

			$cs_rcpt = array_diff($cs_rcpt, $cs_author);

			if (any($cs_rcpt)) {
				if (any($cs_author)) {
					$mail->reply_to = implode(', ', $cs_author);
				}

				$mail->rcpt = $cs_rcpt;
				return $mail->send();
			}

			return true;
		}
	}
}
