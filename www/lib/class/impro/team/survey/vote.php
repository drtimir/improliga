<?

namespace Impro\Team\Survey
{
	class Vote extends \System\Model\Database
	{
		static protected $attrs = array(
			"answer" => array('belongs_to', "model" => 'Impro\Team\Survey\Answer'),
			"survey" => array('belongs_to', "model" => 'Impro\Team\Survey'),
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
