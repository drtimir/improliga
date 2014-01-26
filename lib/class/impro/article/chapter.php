<?

namespace Impro\Article
{
	class Chapter extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"      => array('varchar'),
			"text"      => array('text'),
			"image"     => array('image', "is_null" => true),
			"video"     => array('video_youtube', "is_null" => true),
			"weight"    => array('int', "is_unsigned" => true),
			"published" => array('bool'),
			"visible"   => array('bool'),
			"article"   => array('belongs_to', "model" => 'Impro\Article'),
		);
	}
}
