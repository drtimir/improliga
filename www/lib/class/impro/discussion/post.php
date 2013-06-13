<?

namespace Impro\Discussion
{
	class Post extends \System\Model\Database
	{
		protected static $attrs = array(
			"text"    => array('text'),
			"visible" => array('bool'),
			"topic"   => array('belongs_to', "model" => '\Impro\Discussion\Topic'),
			"board"   => array('belongs_to', "model" => '\Impro\Discussion\Board'),
			"parent"  => array('belongs_to', "model" => '\Impro\Discussion\Post', "is_null" => true),
			"author"  => array('belongs_to', "model" => '\System\User'),
			"responses" => array('has_many', "model" => '\Impro\Discussion\Post', "foreign_name" => 'id_parent'),
		);


		public function save()
		{
			parent::save();
			$this->topic->update_attrs(array("updated_at" => new \DateTime(), "id_last_post_author" => $this->author->id))->save();
			return $this;
		}
	}
}
