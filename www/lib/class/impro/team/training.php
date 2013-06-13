<?

namespace Impro\Team
{
	class Training extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"     => array('varchar'),
			"desc"     => array('varchar'),
			"open"     => array('bool'),
			"start"    => array('datetime'),
			"location" => array('belongs_to', "model" => 'System\Location', "is_null" => true),
			"team"     => array('belongs_to', "model" => 'Impro\Team'),
			"author"   => array('belongs_to', "model" => 'System\User'),
			"acks"     => array('has_many', "model" => 'Impro\Team\Training\Ack'),
		);


		public function send_invites(\System\Template\Renderer $ren)
		{
			$members = $this->team->members->fetch();
			$rcpt = array();

			foreach ($members as $member) {
				$ack = \Impro\Team\Training\Ack::send($ren, $this, $member);
			}
		}
	}
}
