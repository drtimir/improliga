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
			"author" => array("model" => '\System\User'),
		);


		public function save()
		{
			if (!$this->id_author) {
				$this->id_author = user()->id;
				$this->author = user();
			}

			$this->topic->update_attrs(array("updated_at" => new \DateTime(), "id_last_post_author" => $this->author->id))->save();
			return parent::save();
		}
	}
}
