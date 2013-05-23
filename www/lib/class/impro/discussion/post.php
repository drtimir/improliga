<?

namespace Impro\Discussion
{
	class Post extends \System\Model\Database
	{
		protected static $attrs = array(
			"text"    => array('text'),
			"visible" => array('bool'),
		);

		protected static $belongs_to = array(
			"topic"  => array("model" => '\Impro\Discussion\Topic'),
			"board"  => array("model" => '\Impro\Discussion\Board'),
			"parent" => array("model" => '\Impro\Discussion\Post', "is_null" => true),
			"author" => array("model" => '\System\User'),
		);

		protected static $has_many = array(
			"responses" => array("model" => '\Impro\Discussion\Post', "foreign_name" => 'id_parent'),
		);


		public function save()
		{
			parent::save();
			$this->topic->update_attrs(array("updated_at" => new \DateTime(), "id_last_post_author" => $this->author->id))->save();
			return $this;
		}
	}
}
