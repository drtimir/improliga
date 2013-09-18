<?

namespace Impro\Team
{
	class Survey extends \System\Model\Database
	{
		static protected $attrs = array(
			"team"    => array('belongs_to', "model" => 'Impro\Team'),
			'name'    => array('varchar'),
			'desc'    => array('text'),
			'multi'   => array('bool'),
			'visible' => array('bool'),
			'active'  => array('bool'),
			'end_at'  => array('datetime', "is_null" => true),
			"answers" => array('has_many', "model" => 'Impro\Team\Survey\Answer'),
			"votes"   => array('has_many', "model" => 'Impro\Team\Survey\Vote'),
		);


		/** Check if current user has voted
		 * @return bool
		 */
		public function voted(\System\User $user)
		{
			return !!$this->votes->where(array("id_user" => $user->id))->count();
		}

	}
}
