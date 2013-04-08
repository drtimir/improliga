<?


namespace Impro\Team
{
	class Comment extends \System\Model\Database
	{
		protected static $attrs = array(
			"text"    => array('text'),
			"visible" => array('bool', "default" => false),
		);


		protected static $belongs_to = array(
			"team" => array("model" => '\Impro\Team'),
			"user" => array("model" => '\System\User'),
		);
	}
}
