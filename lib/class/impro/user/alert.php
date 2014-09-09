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
		const TEMPLATE_INVITE_TEAM_NEW = 5;
		const TEMPLATE_INVITE_TRAINING = 4;
		const TEMPLATE_NOTICE_JOINED   = 6;

		const RESPONSE_YES   = 1;
		const RESPONSE_NO    = 2;
		const RESPONSE_MAYBE = 3;

		const STATUS_READY   = 1;
		const STATUS_SENT    = 2;
		const STATUS_FAILED  = 3;
		const STATUS_NO_RCPT = 4;


		protected static $links = array(
			self::TEMPLATE_NOTICE          => 'user_notice',
			self::TEMPLATE_REQUEST         => 'user_request',
			self::TEMPLATE_INVITE_TEAM     => 'team_member_join',
			self::TEMPLATE_INVITE_TEAM_NEW => 'team_member_register',
			self::TEMPLATE_INVITE_TRAINING => 'team_member_join_training',
		);


		protected static $attrs = array(
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
				self::TEMPLATE_INVITE_TEAM_NEW => 'invite-team-new',
				self::TEMPLATE_INVITE_TRAINING => 'invite-training',
				self::TEMPLATE_NOTICE_JOINED   => 'notice-joined',
			)),

			"response"     => array('int', "is_null" => true, "options" => array(
				self::RESPONSE_YES    => 'yes',
				self::RESPONSE_NO     => 'no',
				self::RESPONSE_MAYBE  => 'maybe',
			)),

			"status"       => array('int', "default" => self::STATUS_READY, "options" => array(
				self::STATUS_READY  => 'alert-ready',
				self::STATUS_SENT   => 'alert-sent',
				self::STATUS_FAILED => 'alert-failed',
			)),

			"generated_by" => array('varchar'),
			"rcpt"         => array('email', "is_null" => true),
			"request"      => array('json'),

			"user"         => array('belongs_to', "is_null" => true, "model" => 'System\User'),
			"code"         => array('belongs_to', "is_null" => true, "model" => 'System\User\Auth\Code'),
			"author"       => array('belongs_to', "is_null" => true, "model" => 'System\User'),
			"event"        => array('belongs_to', "is_null" => true, "model" => 'Impro\Event'),
			"team"         => array('belongs_to', "is_null" => true, "model" => 'Impro\Team'),
			"member"       => array('belongs_to', "is_null" => true, "model" => 'Impro\Team\Member'),
			"training"     => array('belongs_to', "is_null" => true, "model" => 'Impro\Team\Training'),

			"canceled"     => array('bool', "default" => false),
			"allow_maybe"  => array('bool', "default" => false),
		);


		protected static $access = array(
			'schema' => true,
			'browse' => true
		);


		public static function generate(array $opts)
		{
			$item = new self($opts);

			return $item->gen_code()->save()->mail();
		}


		public function gen_code()
		{
			$this->code = \System\User\Auth\Code::generate($this->user);
			return $this;
		}


		public function get_template()
		{
			return self::get_model_attr_options($this, 'template')[$this->template];
		}


		public function get_link_path()
		{
			return self::$links[$this->template];
		}


		public function get_link()
		{
			$path = \System\Router::get_first_url($this->get_link_path(), array($this->code->uid));

			if (!$path) throw new \System\Error\Wtf('User alert path not found', $this->get_link_path());

			return 'http://'.$this->request->host.$path.'?auth_code='.$this->code->key;
		}


		public function get_mail_data()
		{
			$data = array(
				"author"      => $this->author,
				"author_name" => $this->author->get_name(),
				"link"        => $this->get_link(),
			);

			if ($this->team) {
				$data['team'] = $this->team;
				$data['team_name'] = $this->team->name_full;
			}

			return $data;
		}


		public function get_mail_from_template()
		{
			$template = $this->get_template();
			$subject  = 'mail-subject-'.$template;
			$body     = 'mail-body-'.$template;
			$locales  = new \System\Locales();
			$data     = $this->get_mail_data();
			$locales->set_locale();


			$subject = stprintf($locales->trans($subject), $data);
			$body    = stprintf($locales->trans($body), $data);

			// Prepend tag to subject of all alerts
			$subject = '[Impro] '.$subject;
			$body   .= "\n\nTento e-mail byl automaticky vygenerován uživatelskou interakcí na Intranetu Improligy. Pokud tento e-mail neměl přijít vám, obraťte se na kontakty Improligy.\nhttp://www.improliga.cz | http://intra.improliga.cz";

			$mail = \System\Offcom\Mail::create($subject, $body);

			return $mail;
		}


		public function mail()
		{
			$cs_rcpt = null;

			if ($this->user) {
				$conds = array(
					"type" => \System\User\Contact::STD_EMAIL,
					"spam" => true,
				);

				$contacts = $this->user->contacts->where($conds)->fetch();
				$cs_rcpt  = collect(array('attr', 'ident'), $contacts, true);
			}

			$mail = $this->get_mail_from_template();
			$contacts_author = $this->author->contacts->where(array(
				"type"   => \System\User\Contact::STD_EMAIL,
				"public" => true,
			))->fetch();

			$cs_author = collect(array('attr', 'ident'), $contacts_author, true);

			if (empty($cs_rcpt)) {
				$cs_rcpt = array($this->rcpt);
			}

			if (any($cs_rcpt)) {
				$cs_rcpt = array_diff($cs_rcpt, $cs_author);

				if (any($cs_author)) {
					$mail->reply_to = implode(', ', $cs_author);
				}

				$mail->rcpt = $cs_rcpt;
				$status = $mail->send();

				if ($status == \System\Offcom\Mail::STATUS_SENT) {
					$this->status = self::STATUS_SENT;
				} else {
					$this->status = self::STATUS_FAILED;
				}

				$this->save();
			} else {
				$this->status = self::STATUS_NO_RCPT;
			}

			return $this->save();
		}


		public function invalidate()
		{
			if ($this->code) {
				$code = $this->code;
				$this->code = null;

				$this->save();
				$this->code->drop();
			}

			return $this;
		}
	}
}
