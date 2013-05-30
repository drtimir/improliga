<?

namespace Impro\User
{
	class Notice extends \System\Model\Database
	{
		protected static $attrs = array(
			"text"         => array('text'),
			"read"         => array('bool'),
			"generated_by" => array('varchar'),
			"redirect"     => array('varchar'),
		);

		protected static $belongs_to = array(
			"user"   => array("model" => '\System\User'),
			"author" => array("model" => '\System\User'),
			"event"  => array("model" => '\Impro\Event', "is_null" => true),
			"team"   => array("model" => '\Impro\Team', "is_null" => true),
		);


		public static function for_user(\System\User $user, array $dataray)
		{
			$notice = new self($dataray);
			$notice->update_attrs(array(
				"id_user" => $user->id,
				"read"    => false,
			));

			return $notice->save();
		}


		public function mail(\System\Locales $locales)
		{
			$contacts = $this->user->contacts->where(array("type" => \System\User\Contact::STD_EMAIL))->fetch();
			$mail = \System\Offcom\Mail::create(
				$locales->trans('intra_user_notice_subject'),
				stprintf($locales->trans('intra_user_notice_mail_body'), array(
					"user_name" => $this->author->get_name(),
					"text" => $this->text,
					"link" => $this->redirect,
				)),
				collect(array('attr', 'ident'), $contacts, true)
			);

			return $mail->send();
		}
	}
}
