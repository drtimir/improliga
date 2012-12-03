<?

namespace Impro
{
	class Event extends \System\Model\Database
	{
		const ID_TYPE_EVENT = 1;
		const ID_TYPE_MATCH = 2;
		const ID_TYPE_SHOW  = 3;


		static private $types_available = array(
			'event_type_event' => self::ID_TYPE_EVENT,
			'event_type_match' => self::ID_TYPE_MATCH,
			'event_type_show'  => self::ID_TYPE_SHOW,
		);


		protected static $attrs = array(
			"id_event_type" => array("int", "is_unsigned" => true, "default" => self::ID_TYPE_EVENT),
			"title"         => array('varchar'),
			"image"         => array('image'),
			"desc_short"    => array('text'),
			"desc_full"     => array('text'),
			"visible"       => array('bool'),
			"start"         => array('datetime'),
			"duration"      => array("int", "is_unsigned" => true, "default" => 0),
			"published"     => array('bool'),
			"publish_at"    => array('datetime'),
		);

		protected static $has_many = array(
			"participants" => array("model" => '\Impro\Event\Participant')
		);


		public static function get_available_types()
		{
			return self::$types_available;
		}
	}
}
