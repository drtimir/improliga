<?

namespace Impro\Event
{
	class Booking extends \System\Model\Database
	{
		protected static $attrs = array(
			"user"      => array('belongs_to', "model" => 'System\User'),
			"event"     => array('belongs_to', "model" => 'Impro\Event'),
			"count"     => array('int', "default"  => 0),
			"active"    => array('bool'),
			"confirmed" => array('bool'),
		);
	}
}
