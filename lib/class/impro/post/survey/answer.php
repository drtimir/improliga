<?

namespace Impro\Post\Survey
{
	class Answer extends \System\Model\Database
	{
		static protected $attrs = array(
			"name"       => array('varchar'),
			"vote_count" => array('int', "default" => 0),
			"red"        => array('int'),
			"green"      => array('int'),
			"blue"       => array('int'),
			"visible"    => array('bool'),
			"deleted"    => array('bool'),
			"votes"      => array('has_many', "model" => '\Impro\Post\Survey\Vote'),
			"survey"     => array('belongs_to', "model" => '\Impro\Post', "conds" => array("type" => \Impro\Post::SURVEY)),
		);

		private $voted = null;


		/** Check if current user has voted
		 * @return bool
		 */
		public function voted(\System\User $user)
		{
			return !!$this->votes->where(array("id_user" => $user->id))->count();
		}


		public function vote(\System\User $user)
		{
			$vote = new \Impro\Team\Survey\Vote(array(
				"survey" => $this->survey,
				"answer" => $this,
				"user"   => $user,
			));

			return $vote->save();
		}
	}
}
