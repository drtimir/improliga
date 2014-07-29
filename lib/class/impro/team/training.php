<?

namespace Impro\Team
{
	class Training extends \System\Model\Perm
	{
		protected static $attrs = array(
			"name"     => array('varchar'),
			"desc"     => array('varchar'),
			"open"     => array('bool'),
			"start"    => array('datetime'),
			"canceled" => array('bool', "default" => false),
			"location" => array('belongs_to', "model" => 'System\Location', "is_null" => true),
			"team"     => array('belongs_to', "model" => 'Impro\Team'),
			"author"   => array('belongs_to', "model" => 'System\User'),
			"acks"     => array('has_many', "model" => 'Impro\Team\Training\Ack'),
		);


		protected static $access = array(
			'schema' => true,
			'browse' => true
		);


		public function can_be($method, \System\User $user)
		{
			$member = get_first('\Impro\Team\Member')->where(array(
				'user' => $user,
				'team' => $this->team
			))->fetch();

			if ($method == \System\Model\Perm::BROWSE) {
				return true;
			}

			return $user->is_root() || in_array(ID_MANAGER, $member->roles) || in_array(ID_TRAINER, $member->roles);
		}


		public function send_invites(\System\Template\Renderer $ren)
		{
			$members = $this->team->members->fetch();

			foreach ($members as $member) {
				$ack = \Impro\Team\Training\Ack::send($ren, $this, $member);
			}
		}


		public function cancel(\System\Template\Renderer $ren, $drop)
		{
			if (!$this->canceled) {
				$acks = $this->acks->where(array(
					"status" => \Impro\Team\Training\Ack::RESPONSE_YES
				))->fetch();

				foreach ($acks as $ack) {
					$ack->cancel($ren, $drop);
				}
			}

			if ($drop) {
				return $this->drop();
			} else {
				$this->canceled = true;
				return $this->save();
			}
		}
	}
}
