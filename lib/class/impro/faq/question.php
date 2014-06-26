<?

namespace Impro\Faq
{
	class Question extends \System\Model\Perm
	{
		protected static $attrs = array(
			"text"     => array('text'),
			"answer"   => array('html'),
			"weight"   => array('int', 'default' => 0),
			"visible"  => array('bool', 'default' => false),
		);
	}
}
