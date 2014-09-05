<?

namespace Impro\Team\Training
{
	class Ack extends \System\Model\Perm
	{
		const NOT_SENT       = 1;
		const SENT           = 2;
		const RESPONSE_YES   = 3;
		const RESPONSE_NO    = 4;
		const RESPONSE_MAYBE = 5;

		protected static $attrs = array(
			"status" => array('int', "options" => array(
				self::NOT_SENT        => 'intra_team_attd_not_sent',
				self::SENT            => 'intra_team_attd_sent',
				self::RESPONSE_YES    => 'intra_team_attd_yes',
				self::RESPONSE_NO     => 'intra_team_attd_no',
				self::RESPONSE_MAYBE  => 'intra_team_attd_maybe',
			)),
			"count"    => array('int', "is_unsigned" => true, "default" => 1, "min" => 1),
			"delay"    => array('int', "default" => 0, "is_null" => true, "min" => 0),
			"canceled" => array('bool', "default" => false),
			"training" => array('belongs_to', "model" => 'Impro\Team\Training'),
			"member"   => array('belongs_to', "model" => 'Impro\Team\Member'),
			"user"     => array('belongs_to', "model" => 'System\User'),
		);


		protected static $access = array(
			'schema' => true,
			'browse' => true
		);


		public static function get_responses(\System\Template\Renderer $ren)
		{
			return array(
				self::RESPONSE_YES   => $ren->trans('intra_attd_yes'),
				self::RESPONSE_NO    => $ren->trans('intra_attd_no'),
				self::RESPONSE_MAYBE => $ren->trans('intra_attd_maybe'),
			);
		}


		public static function send(\System\Template\Renderer $ren, \Impro\Team\Training $training, \Impro\Team\Member $member)
		{
			if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ATTENDANCE)) {
				$ack = create('\Impro\Team\Training\Ack', array(
					"status"   => self::NOT_SENT,
					"training" => $training,
					"member"   => $member,
					"user"     => $member->user,
				));

				$invite = \Impro\User\Alert::generate(array(
					'allow_maybe'  => true,
					'author'       => $training->author,
					'generated_by' => 'organic-invite',
					'member'       => $member,
					'request'      => $training->request,
					'team'         => $training->team,
					'template'     => \Impro\User\Alert::TEMPLATE_INVITE_TRAINING,
					'training'     => $training,
					'type'         => \Impro\User\Alert::TYPE_REQUEST,
					'user'         => $member->user,
				));

				if ($invite->status == \Impro\User\Alert::STATUS_SENT) {
					$ack->status = self::SENT;
					$ack->save();
				}

				return $ack;
			}
		}


		public function cancel(\System\Template\Renderer $ren, $drop)
		{
			$this->canceled = true;
			$this->save();
			$current_user = $ren->response()->request()->user();

			if ($this->id_user != $current_user->id) {
				$notice = \Impro\User\Notice::for_user($this->user, array(
					"generated_by" => 'team_attendance',
					"redirect"     => $drop ?
						$ren->url('team_attendance', array($this->training->team)):
						$ren->url('team_training', array($this->training->team, $this->training)),
					"author"       => $current_user,
					"team"         => $this->training->team,
					"text"         => stprintf($ren->trans('training_cancel_mail'), array(
						"link_user" => \Impro\User::link($ren),
						"link_team" => $this->training->team->to_html_link($ren, true),
						"tg_date"   => $ren->format_date($this->training->start, 'human'),
					))
				));
			}

			return $this;
		}


		public function get_status_name(\System\Template\Renderer $ren)
		{
			$opts = self::get_model_attr_options(get_class($this), 'status');
			foreach ($opts as $id=>$name) {
				if ($id == $this->status) {
					return $ren->trans($name);
				}
			}

			return null;
		}


		public static function get_status_class(\System\Template\Renderer $ren, $attd)
		{
			if ($attd instanceof \Impro\Team\Training\Ack) {
				if ($attd->status == \Impro\Team\Training\Ack::NOT_SENT) {
					$status = 'not-sent';
					$title = $ren->trans('intra_team_attd_not_sent');
					$c = '?';
				}

				if ($attd->status == \Impro\Team\Training\Ack::SENT) {
					$status = 'sent';
					$title = $ren->trans('intra_team_attd_sent');
					$c = '.';
				}

				if ($attd->status == \Impro\Team\Training\Ack::RESPONSE_YES) {
					$status = 'yes';
					if ($attd->count > 1) {
						$title = $ren->trans('intra_team_attd_yes_guests', $attd->count);
					} else {
						$title = $ren->trans('intra_team_attd_yes');
					}
					$c = $attd->count;
				}

				if ($attd->status == \Impro\Team\Training\Ack::RESPONSE_NO) {
					$status = 'no';
					$title = $ren->trans('intra_team_attd_no');
					$c = '-';
				}

				if ($attd->status == \Impro\Team\Training\Ack::RESPONSE_MAYBE) {
					$status = 'maybe';
					$title = $ren->trans('intra_team_attd_maybe');
					$c = '?';
				}
			} else {
				$status = 'no-info';
				$title = $ren->trans('intra_team_attd_no_info');
				$c = '?';
			}

			return array(
				"status" => $status,
				"title"  => $title,
				"c"      => $c,
			);
		}
	}
}
