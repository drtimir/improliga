<?

namespace Impro\Team
{
	class Training extends \System\Model\Perm
	{
		protected static $callbacks = array(
			self::AFTER_SAVE => array('send_invites'),
		);


		protected static $attrs = array(
			"team"     => array('belongs_to', "model" => 'Impro\Team'),
			"name"     => array('varchar'),
			"start"    => array('datetime'),
			"open"     => array('bool'),
			"canceled" => array('bool', "default" => false),

			"location" => array('belongs_to', "model" => 'System\Location', "is_null" => true),
			"lector"   => array('belongs_to', "model" => 'System\User', "is_null" => true),

			"desc"     => array('html'),
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
				'id_system_user' => $user->id,
				'id_impro_team' => $this->team->id,
			))->fetch();

			if ($method == \System\Model\Perm::BROWSE) {
				return true;
			}

			return $user->is_root() || in_array(ID_MANAGER, $member->roles) || in_array(ID_TRAINER, $member->roles);
		}


		public function send_invites()
		{
			$members = $this->team->members->fetch();

			foreach ($members as $member) {
				if ($member->id != $this->author->id) {
					$ack = \Impro\Team\Training\Ack::send($this, $member);
				}
			}
		}


		public function cancel($drop = false)
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
