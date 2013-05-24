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
		);


		protected static $belongs_to = array(
			"code"   => array("model" => '\System\User\Auth\Code'),
			"user"   => array("model" => '\System\User'),
			"author" => array("model" => '\System\User'),
			"event"  => array("model" => '\Impro\Event', "is_null" => true),
			"team"   => array("model" => '\Impro\Team', "is_null" => true),
		);


		public static function for_user(\System\User $user, array $dataray)
		{
			$code = \System\User\Auth\Code::generate($user);
			$req = new self($dataray);
			$req->update_attrs(array(
				"id_user"  => $user->id,
				"id_code"  => $code->id,
				"read"     => false,
				"response" => null,
			));

			return $req->validate()->save();
		}


		public function mail(\System\Template\Renderer $ren)
		{
			$contacts = $this->user->contacts->where(array("type" => \System\User\Contact::STD_EMAIL))->fetch();

			$mail = \System\Offcom\Mail::create(
				l('intra_request_subject'),
				stprintf(l('intra_request_mail_body'), array(
					"text" => $this->text,
					"link" => $ren->url('request', array($this->code->uid, $this->id, $this->code->key)),
				)),
				collect(array('attr', 'ident'), $contacts, true)
			);

			return $this;
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
			if ($this->callback) {
				$name   = '\\Impro\\User\\Request\\'.$this->callback;
				$method = null;

				if ($value == self::RESPONSE_YES) {
					$method = 'yes';
				} else if ($value == self::RESPONSE_NO) {
					$method = 'no';
				} else if ($value == self::RESPONSE_MAYBE) {
					$method = 'maybe';
				}

				if (is_null($method)) {
					throw new \System\Error\Argument(sprintf("Did not recognize value '%s' for user request.", $value));
				}

				if (class_exists($name)) {
					if (method_exists($name, $method)) {
						$response = $name::$method($this);

						if ($response) {
							$url = $this->__get('redirect_'.$method);
							$this->code->drop();

							redirect_now($url ? $url:'/');
							return $this;
						} else throw new \System\Error\Code(sprintf("Callback method '%s' did not return true. It maybe failed.", $name.'::'.$method));
					} else throw new \System\Error\Code(sprintf("Callback method '%s' was not found.", $name.'::'.$method));
				} else throw new \System\Error\Model(sprintf("Callback model '%s' was not found.", $name));
			}

			return $this;
		}
	}
}
