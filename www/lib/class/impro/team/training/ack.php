<?

namespace Impro\Team\Training
{
	class Ack extends \System\Model\Database
	{
		const NOT_SENT       = 1;
		const SENT           = 2;
		const RESPONSE_YES   = 3;
		const RESPONSE_NO    = 4;
		const RESPONSE_MAYBE = 5;

		protected static $attrs = array(
			"status" => array('int', "options" => array(
				self::NOT_SENT        => 'not sent',
				self::SENT            => 'sent',
				self::RESPONSE_YES    => 'yes',
				self::RESPONSE_NO     => 'no',
				self::RESPONSE_MAYBE  => 'maybe',
			)),
			"count"    => array('int', "is_unsigned" => true, "default" => 1),
			"delay"    => array('int', "default" => 0, "is_null" => true),
			"training" => array('belongs_to', "model" => 'Impro\Team\Training'),
			"member"   => array('belongs_to', "model" => 'Impro\Team\Member'),
			"user"     => array('belongs_to', "model" => 'System\User'),
		);


		public static function send(\System\Template\Renderer $ren, \Impro\Team\Training $training, \Impro\Team\Member $member)
		{
			if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ATTENDANCE)) {
				$ack = create('\Impro\Team\Training\Ack', array(
					"status"   => self::NOT_SENT,
					"training" => $training,
					"member"   => $member,
					"user"     => $member->user,
				));

				$invite = \Impro\User\Request::for_user($member->user, array(
					"author"         => $training->author,
					"allow_maybe"    => true,
					"callback"       => 'JoinTraining',
					"redirect_yes"   => $ren->uri('team_attendance', array($training->team)),
					"redirect_no"    => $ren->uri('team_attendance', array($training->team)),
					"redirect_maybe" => $ren->uri('team_attendance', array($training->team)),
					"training"       => $training,
					"member"         => $member,
					"text"           => stprintf($ren->locales()->trans('intra_team_training_invite'), array(
						"link_team"    => $training->team->to_html_link($ren),
						"link_user"    => \Impro\User::link($ren, $training->author),
					)),
				));

				if ($invite->mail($ren) == \System\Offcom\Mail::STATUS_SENT) {
					$ack->status = self::SENT;
					$ack->save();
				}

				return $ack;
			}
		}
	}
}
