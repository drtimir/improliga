<?

namespace Impro\User
{
	class Request extends \System\Model\Database
	{
		const RESPONSE_YES   = 1;
		const RESPONSE_NO    = 2;
		const RESPONSE_MAYBE = 3;

		protected static $attrs = array(
			"text"     => array('text'),
			"read"     => array('bool'),
			"response" => array('int', "is_null" => true, "options" => array(
				self::RESPONSE_YES    => 'yes',
				self::RESPONSE_NO     => 'no',
				self::RESPONSE_MAYBE  => 'maybe',
			)),
			"generated_by"   => array('varchar'),
			"callback"       => array('varchar'),
			"redirect_yes"   => array('varchar'),
			"redirect_no"    => array('varchar'),
			"redirect_maybe" => array('varchar', 'default' => ''),
			"allow_maybe"    => array('bool'),
			"code"           => array('belongs_to', "model" => '\System\User\Auth\Code'),
			"user"           => array('belongs_to', "model" => '\System\User'),
			"author"         => array('belongs_to', "model" => '\System\User'),
			"event"          => array('belongs_to', "model" => '\Impro\Event', "is_null" => true),
			"team"           => array('belongs_to', "model" => '\Impro\Team', "is_null" => true),
			"member"         => array('belongs_to', "model" => '\Impro\Team\Member', "is_null" => true),
			"training"       => array('belongs_to', "model" => '\Impro\Team\Training', "is_null" => true),
		);


		public static function for_user(\System\User $user, array $dataray)
		{
			$code = \System\User\Auth\Code::generate($user);
			$req = new self($dataray);
			$req->update_attrs(array(
				"user"     => $user,
				"code"     => $code,
				"read"     => false,
				"response" => null,
			));

			return $req->validate()->save();
		}


		public function mail(\System\Template\Renderer $ren)
		{
			$contacts = $this->user->contacts->where(array("type" => \System\User\Contact::STD_EMAIL))->fetch();
			$mail = \System\Offcom\Mail::create(
				$ren->locales()->trans('intra_user_request_subject'),
				stprintf($ren->locales()->trans('intra_user_request_mail_body'), array(
					"user_name" => $this->author->get_name(),
					"text" => $this->text,
					"link" => $ren->uri('request', array($this->code->uid, $this->id, $this->code->key)),
				)),
				collect(array('attr', 'ident'), $contacts, true)
			);

			return $mail->send();
		}


		public function mail_response(\System\Template\Renderer $ren)
		{
			if ($this->response && $this->response !== self::RESPONSE_MAYBE) {
				$contacts = $this->author->contacts->where(array("type" => \System\User\Contact::STD_EMAIL))->fetch();
				$method = self::get_method($this->response);
				$mail = \System\Offcom\Mail::create(
					$ren->locales()->trans('intra_user_request_response_subject'),
					stprintf($ren->locales()->trans('intra_user_request_response_mail_body_'.$method), array(
						"user_name" => $this->user->get_name(),
						"text" => $this->text,
					)),
					collect(array('attr', 'ident'), $contacts, true)
				);

				return $mail->send();
			}

			return false;
		}


		public function validate()
		{
			if (is_null($this->generated_by)) {
				throw new \System\Error\Argument("Attribute 'generated_by' must be set before saving user request.");
			}

			return $this;
		}


		public function callback($value)
		{
			$method = self::get_method($value);

			if ($this->callback) {
				$name   = '\\Impro\\User\\Request\\'.$this->callback;

				if (class_exists($name)) {
					if (method_exists($name, $method)) {
						$response = $name::$method($this);

						if ($response) {
							$this->code->drop();
						} else throw new \System\Error\Code(sprintf("Callback method '%s' did not return true. It maybe failed.", $name.'::'.$method));
					} else throw new \System\Error\Code(sprintf("Callback method '%s' was not found.", $name.'::'.$method));
				} else throw new \System\Error\Model(sprintf("Callback model '%s' was not found.", $name));
			}

			$this->read = true;
			$this->response = $value;

			return $this->save();
		}


		public function redirect()
		{
			if ($this->response) {
				$method = self::get_method($this->response);
				$url    = $this->__get('redirect_'.$method);

				return redirect_now($url ? $url:'/');
			}
		}


		public static function get_method($value)
		{
			$method = null;

			if ($value == self::RESPONSE_YES) $method = 'yes';
			elseif ($value == self::RESPONSE_NO) $method = 'no';
			elseif ($value == self::RESPONSE_MAYBE) $method = 'maybe';

			if (is_null($method)) {
				throw new \System\Error\Argument(sprintf("Did not recognize value '%s' for user request.", $value));
			}

			return $method;
		}
	}
}
