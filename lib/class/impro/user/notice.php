<?

namespace Impro\User
{
	class Notice extends \System\Model\Database
	{
		protected static $attrs = array(
			"user"         => array('belongs_to', "model" => 'System\User'),
			"text"         => array('text'),
			"read"         => array('bool'),
			"generated_by" => array('varchar'),
			"redirect"     => array('varchar'),
			"author"       => array('belongs_to', "model" => 'System\User'),
			"event"        => array('belongs_to', "model" => 'Impro\Event', "is_null" => true),
			"team"         => array('belongs_to', "model" => 'Impro\Team', "is_null" => true),
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
			$contacts = $this->user->contacts->where(array(
				"type" => \System\User\Contact::STD_EMAIL,
				"spam" => true,
			))->fetch();
			$mail = \System\Offcom\Mail::create(
				$locales->trans('intra_user_notice_subject'),
				stprintf($locales->trans('intra_user_notice_mail_body'), array(
					"user_name" => $this->author->get_name(),
					"text" => $this->text,
					"link" => $this->redirect,
				)),
				collect(array('attr', 'ident'), $contacts, true)
			);

			$acontacts = $this->author->contacts->where(array(
				"type" => \System\User\Contact::STD_EMAIL, "public" => true,
				))->fetch();

			if (any($acontacts)) {
				$mail->reply_to = implode(', ', collect(array('attr', 'ident'), $acontacts, true));
			}

			return $mail->send();
		}
	}
}
