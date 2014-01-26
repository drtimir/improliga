<?

namespace Impro\Post\Survey
{
	class Vote extends \System\Model\Database
	{
		static protected $attrs = array(
			"answer" => array('belongs_to', "model" => 'Impro\Post\Survey\Answer'),
			"survey" => array('belongs_to', "model" => 'Impro\Post', "conds" => array("type" => \Impro\Post::SURVEY)),
			"user"   => array('belongs_to', "model" => 'System\User'),
		);


		public function save()
		{
			parent::save();
			$this->answer->vote_count ++;
			$this->answer->save();

			return $this;
		}
	}
}
