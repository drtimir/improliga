<?

namespace Impro\Discussion
{
	class Board extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"desc"    => array('text'),
			"locked"  => array('bool'),
			"visible" => array('bool'),
			"public"  => array('bool'),
			"team"    => array('belongs_to', "model" => '\Impro\Team'),
			"author"  => array('belongs_to', "model" => '\System\User'),
			"topics"  => array('has_many', "model" => 'Impro\Discussion\Topic', "foreign_name" => 'id_board'),
			"posts"   => array('has_many', "model" => 'Impro\Discussion\Post',  "foreign_name" => 'id_board'),
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
