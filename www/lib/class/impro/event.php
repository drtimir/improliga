<?

namespace Impro
{
	class Event extends \System\Model\Database
	{
		const DURATION_DEFAULT = 86399;

		const ID_WIZZARD_STEP_NAME         = 'name';
		const ID_WIZZARD_STEP_TIMESPACE    = 'timespace';
		const ID_WIZZARD_STEP_TEAMS        = 'teams';
		const ID_WIZZARD_STEP_PARTICIPANTS = 'participants';
		const ID_WIZZARD_STEP_TOOLS        = 'tools';
		const ID_WIZZARD_STEP_POSTER       = 'poster';
		const ID_WIZZARD_STEP_PUBLISH      = 'publish';
		const ID_WIZZARD_STEP_CANCEL       = 'cancel';

		const ID_SETUP_STATUS_NO = 0;
		const ID_SETUP_STATUS_OK = 1;
		const ID_SETUP_STATUS_NOT_NEEDED = 2;

		protected static $attrs = array(
			"name"          => array('varchar'),
			"type"          => array("int", "is_unsigned" => true, "default" => Event\Type::ID_SHOW, "options" => array('callback', '\Impro\Event\Type', 'get_all')),
			"team_home"     => array('belongs_to', "model" => 'Impro\Team', "is_null" => true),
			"team_away"     => array('belongs_to', "model" => 'Impro\Team', "is_null" => true),
			"location"      => array('belongs_to', "model" => 'System\Location', "is_null" => true),
			"image"         => array('image'),
			"desc_short"    => array('text', "default" => ''),
			"desc_full"     => array('text', "default" => ''),
			"start"         => array('datetime'),
			"end"           => array('datetime', "is_null" => true),
			"publish_at"    => array('datetime', "is_null" => true),
			"capacity"      => array('int', "default" => 0),
			"price"         => array('int', "is_null" => true),
			"price_student" => array('int', "is_null" => true),

			"use_booking"   => array('bool'),
			"visible"       => array('bool'),
			"published"     => array('bool'),
			"publish_wait"  => array('bool'),
			"author"        => array('belongs_to', "model" => "System\User"),

			"has_whistle"   => array('int', "default" => 0),
			"has_kazoo"     => array('int', "default" => 0),
			"has_mic"       => array('int', "default" => 0),
			"has_dress_ref" => array('int', "default" => 0),
			"has_dress_oth" => array('int', "default" => 0),
			"has_cards"     => array('int', "default" => 0),
			"has_basket"    => array('int', "default" => 0),
			"has_papers"    => array('int', "default" => 0),
			"has_pencils"   => array('int', "default" => 0),
			"has_camera"    => array('int', "default" => 0),
			"has_photo"     => array('int', "default" => 0),

			"participants"  => array('has_many', "model" => 'Impro\Event\Participant'),
			"reservations"  => array('has_many', "model" => 'Impro\Event\Booking')
		);


		private static $wizzard_steps = array(
			self::ID_WIZZARD_STEP_NAME         => 'impro_event_wizzard_step_name',
			self::ID_WIZZARD_STEP_TEAMS        => 'impro_event_wizzard_step_teams',
			self::ID_WIZZARD_STEP_TIMESPACE    => 'impro_event_wizzard_step_timespace',
			self::ID_WIZZARD_STEP_PARTICIPANTS => 'impro_event_wizzard_step_participants',
			self::ID_WIZZARD_STEP_TOOLS        => 'impro_event_wizzard_step_tools',
			self::ID_WIZZARD_STEP_POSTER       => 'impro_event_wizzard_step_poster',
			self::ID_WIZZARD_STEP_PUBLISH      => 'impro_event_wizzard_step_publish',
		);


		public static function wizzard_for(\System\User $user, $id = 0, $new = false)
		{
			if (!$id) {
				if (any($_SESSION['impro_event_wizzard_id'])) {
					$id = $_SESSION['impro_event_wizzard_id'];
				}
			}

			$event = find('\Impro\Event', $id);

			if ($new && !$event) {
				$event = new self(array(
					"type"        => \Impro\Event\Type::ID_MATCH,
					"name"        => 'Nová událost',
					"published"   => false,
					"visible"     => false,
					"id_author"   => $user->id,
					"start"       => new \DateTime(),
					"use_booking" => true,
				));
			}

			if ($event) {
				if (!$event->id) {
					$event->save();
				}

				if ($new) {
					$_SESSION['impro_event_wizzard_id'] = $event->id;
				}
			}

			return $event;
		}


		public static function free_wizzard()
		{
			unset($_SESSION['impro_event_wizzard_id']);
		}


		public static function cancel_wizzard()
		{
			if (any($_SESSION['impro_event_wizzard_id'])) {
				$id = $_SESSION['impro_event_wizzard_id'];
			}

			$event = find('\Impro\Event', $id);

			if ($event) {
				$event->drop();
			}
		}


		public static function get_wizzard_steps()
		{
			$steps = array();

			foreach (self::$wizzard_steps as $step=>$trans) {
				$steps[$step] = $trans;
			}

			return $steps;
		}


		public function get_type_name()
		{
			return \Impro\Event\Type::get_by_id($this->type);
		}


		public function duration()
		{
			if ($this->end instanceof \DateTime) {
				$dur = $this->end->getTimestamp() - $this->start->getTimestamp();
				return $dur > 0 ? $dur:self::DURATION_DEFAULT;
			} else return self::DURATION_DEFAULT;
		}


		public function has($what)
		{
			$var = 'has_'.$what;
			return in_array($this->$var, array(self::ID_SETUP_STATUS_OK, self::ID_SETUP_STATUS_NOT_NEEDED));
		}


		public function has_all_tools()
		{
			$ok = true;

			foreach (self::get_tools() as $item) {
				if ($ok) {
					$ok = $this->has($item);
				} else {
					break;
				}
			}

			return $ok;
		}


		public static function get_tools()
		{
			return array("whistle", "kazoo", "mic", "dress_ref", "dress_oth", "cards", "basket", "papers", "pencils", "camera", "photo");
		}


		public function assign(array $roles)
		{
			$event_participants = $this->participants->fetch();
			$participants = array();
			$delete = array();

			foreach ($roles as $role => $ids) {
				foreach ($event_participants as $participant) {
					if (in_array($participant->id_player, $ids)) {
						$participant->type = $role;
						$participants[$participant->id_impro_team_member] = $participant;
					}
				}

				foreach ($ids as $id) {
					if (!isset($participants[$id])) {
						$participants[$id] = new \Impro\Event\Participant(array(
							"id_impro_event" => $this->id,
							"id_impro_team_member" => $id,
							"type" => $role,
						));
					}
				}
			}

			foreach ($event_participants as $part) {
				//~ if (!isset($participants[$part->id_impro_team_member])) {
					$part->drop();
				//~ }
			}

			foreach ($participants as $part) {
				$part->save();
			}
		}


		public function to_html(\System\Template\Renderer $ren)
		{
			return div('event', array(
				div('event_image', $ren->link_for('event', $this->image->to_html($ren, 78, 56), args($this))),
				div('event_info', array(
					span('part name', $ren->link_for('event', $this->name, args($this))),
					$this->location ? span('part city', $ren->link_ext($this->location->map_link(), $this->location->name)):'',
					span('part date', $ren->format_date($this->start, 'human-full-datetime')),
				)),
				span('cleaner', ''),
			));
		}
	}
}
