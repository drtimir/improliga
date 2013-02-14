<?

namespace Impro
{
	class Event extends \System\Model\Database
	{
		const DURATION_DEFAULT = 86399;

		protected static $attrs = array(
			"id_impro_event_type" => array("int", "is_unsigned" => true, "default" => Event\Type::ID_SHOW),
			"title"         => array('varchar'),
			"image"         => array('image'),
			"desc_short"    => array('text'),
			"desc_full"     => array('text'),
			"visible"       => array('bool'),
			"start"         => array('datetime'),
			"end"           => array('datetime', "is_null" => true),
			"capacity"      => array('int', "default" => 0),
			"published"     => array('bool'),
			"publish_at"    => array('datetime', "is_null" => true),
		);


		protected static $has_many = array(
			"participants" => array("model" => '\Impro\Event\Participant'),
			"reservations" => array("model" => '\Impro\Event\Booking')
		);

		protected static $belongs_to = array(
			"author"    => array("model" => "\System\User"),
			"team_home" => array("model" => '\Impro\Team', "is_null" => true),
			"team_away" => array("model" => '\Impro\Team', "is_null" => true),
			"gallery"   => array("model" => '\Impro\Gallery'),
			"location"  => array("model" => '\System\Location'),
		);


		public function get_type_name()
		{
			return \Impro\Event\Type::get_by_id($this->id_impro_event_type);
		}


		public function duration()
		{
			if ($this->end instanceof \DateTime) {
				$dur = $this->end->getTimestamp() - $this->start->getTimestamp();
				return $dur > 0 ? $dur:self::DURATION_DEFAULT;
			} else return self::DURATION_DEFAULT;
		}
	}
}
