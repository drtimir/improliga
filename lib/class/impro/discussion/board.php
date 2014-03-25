<?

namespace Impro\Discussion
{
	class Board extends \System\Model\Perm
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"desc"    => array('text'),
			"locked"  => array('bool'),
			"visible" => array('bool'),
			"public"  => array('bool'),
			"team"    => array('belongs_to', "model" => 'Impro\Team'),
			"author"  => array('belongs_to', "model" => 'System\User'),
			"topics"  => array('has_many', "model" => 'Impro\Discussion\Topic', "foreign_name" => 'id_board'),
			"posts"   => array('has_many', "model" => 'Impro\Discussion\Post',  "foreign_name" => 'id_board'),
		);


		public function latest()
		{
			return $this->topics->where(array("visible" => true))->sort_by('updated_at DESC')->paginate(10, 0)->fetch();
		}


		public function is_managable(\System\User $user)
		{
			return \Impro\Discussion::is_managable($user, $this);
		}
	}
}
