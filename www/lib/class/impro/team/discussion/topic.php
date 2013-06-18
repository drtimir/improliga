<?

namespace Impro\Team\Discussion
{
	class Topic extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"             => array('varchar'),
			"desc"             => array('text'),
			"locked"           => array('bool'),
			"visible"          => array('bool'),
			"team"             => array('belongs_to', "model" => 'Impro\Team'),
			"author"           => array('belongs_to', "model" => 'System\User'),
			"last_post_author" => array('belongs_to', "model" => 'System\User'),
			"posts"            => array('has_many', "model" => 'Impro\Team\Discussion\Post'),
		);
	}
}
