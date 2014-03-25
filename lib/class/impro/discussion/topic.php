<?

namespace Impro\Discussion
{
	class Topic extends \System\Model\Perm
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"desc"    => array('text'),
			"locked"  => array('bool'),
			"visible" => array('bool'),
			"board"            => array('belongs_to', "model" => 'Impro\Discussion\Board'),
			"author"           => array('belongs_to', "model" => 'System\User'),
			"last_post_author" => array('belongs_to', "model" => 'System\User'),
			"posts" => array('has_many', "model" => 'Impro\Discussion\Post', "foreign_name" => 'id_topic'),
		);


		public function save()
		{
			parent::save();
			$this->board->update_attrs(array("updated_at" => new \DateTime(), "id_last_post_author" => $this->id_author))->save();
			return $this;
		}


		public function is_managable(\System\User $user)
		{
			return \Impro\Discussion::is_managable($user, $this);
		}
	}
}
