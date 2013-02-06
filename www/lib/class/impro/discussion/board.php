<?

namespace Impro\Discussion
{
	class Board extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"desc"    => array('varchar'),
			"locked"  => array('bool'),
			"visible" => array('bool'),
			"public"  => array('bool'),
		);

		protected static $belongs_to = array(
			"team"   => array("model" => '\Impro\Team'),
			"author" => array("model" => '\System\User'),
		);


		protected static $has_many = array(
			"topics" => array("model" => '\Impro\Discussion\Topic', "foreign_name" => 'id_board'),
			"posts"  => array("model" => '\Impro\Discussion\Post',  "foreign_name" => 'id_board'),
		);


		public static function get_team_board($id_team)
		{
			$board_sql = get_first('\Impro\Discussion\Board')->where(array("id_team" => $id_team));

			if ($board_sql->count() == 0) {
				$team = find('\Impro\Team', $id_team);

				create('\Impro\Discussion\Board', array(
					"name"    => $team->name,
					"visible" => true,
					"public"  => true,
				));
			}

			return $board_sql->fetch();
		}


		public function latest()
		{
			return $this->topics->where(array("visible" => true))->sort_by('created_at DESC')->paginate(10, 0)->fetch();
		}
	}
}
