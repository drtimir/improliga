<?

namespace Impro\Team
{
	class Member extends \System\Model\Database
	{
		protected static $attrs = array(
			"roles"  => array("int_set"),
			"active" => array("bool"),
		);


		protected static $belongs_to = array(
			"team" => array("model" => "\Impro\Team", "is_natural" => true),
			"user" => array("model" => "\System\User", "is_natural" => true),
		);


		public function get_name()
		{
			return $this->user->get_name();
		}
	}
}
