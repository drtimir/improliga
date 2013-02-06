<?

namespace Impro\Discussion
{
	class Topic extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"desc"    => array('text'),
			"locked"  => array('bool'),
			"visible" => array('bool'),
		);

		protected static $belongs_to = array(
			"board"            => array("model" => '\Impro\Discussion\Board'),
			"author"           => array("model" => '\System\User'),
			"last_post_author" => array("model" => '\System\User'),
		);

		protected static $has_many = array(
			"posts" => array("model" => '\Impro\Discussion\Post', "foreign_name" => 'id_topic'),
		);


		public function save()
		{
			if (!$this->id_author) {
				$this->id_author = user()->id;
				$this->author = user();
			}

			$this->board->update_attrs(array("updated_at" => new \DateTime(), "id_last_post_author" => $this->id_author))->save();
			return parent::save();
		}
	}
}
