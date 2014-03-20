<?

namespace Impro
{
	class Gallery extends \System\Model\Database
	{
		protected static $attrs = array(
			"team"  => array('belongs_to', "model" => "Impro\Team"),
			"event" => array('belongs_to', "model" => "Impro\Team"),
			"name"  => array('varchar'),
			"desc"  => array('text'),
			"visible" => array('bool'),
			"public"  => array('bool'),
			"author" => array('belongs_to', "model" => "System\User"),
			"photos" => array('has_many', "model" => 'Impro\Gallery\Photo'),
			"videos" => array('has_many', "model" => 'Impro\Gallery\Video'),
		);
	}
}
