<?

namespace Impro\Event
{
	class Booking extends \System\Model\Database
	{
		protected static $attrs = array(
			"count"     => array('int', "default"  => 0),
			"active"    => array('bool'),
			"confirmed" => array('bool'),
		);

		protected static $belongs_to = array(
			"user"  => array("model" => '\System\User'),
			"event" => array("model" => '\Impro\Event'),
		);
	}
}
