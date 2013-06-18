<?

namespace Impro\Team\Discussion
{
	class Post extends \System\Model\Database
	{
		protected static $attrs = array(
			"text"      => array('text'),
			"visible"   => array('bool'),
			"team"      => array('belongs_to', "model" => 'Impro\Team'),
			"topic"     => array('belongs_to', "model" => 'Impro\Team\Discussion\Topic'),
			"parent"    => array('belongs_to', "model" => 'Impro\Team\Discussion\Post', "is_null" => true),
			"author"    => array('belongs_to', "model" => 'System\User'),
			"responses" => array('has_many', "model" => 'Impro\Team\Discussion\Post'),
		);


		public function save()
		{
			parent::save();
			$this->topic->update_attrs(array("updated_at" => new \DateTime(), "last_post_author" => $this->author))->save();
			return $this;
		}
	}
}
