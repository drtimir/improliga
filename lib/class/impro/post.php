<?

namespace Impro
{
	class Post extends \System\Model\Perm
	{
		const MESSAGE = 1;
		const SURVEY  = 2;
		const IMAGE   = 3;
		const FILE    = 4;


		protected static $attrs = array(
			'type' => array('int', 'options' => array(
				self::MESSAGE => 'impro_post_message',
				self::SURVEY  => 'impro_post_survey',
				self::IMAGE   => 'impro_post_image',
				self::FILE    => 'impro_post_file',
			)),

			'name'       => array('varchar', 'default' => ''),
			'text'       => array('text', 'default' => ''),
			'end_at'     => array('datetime', 'is_null' => true),

			'visible'    => array('bool'),
			'public'     => array('bool'),
			'multi'      => array('bool'),
			'active'     => array('bool'),

			'answers'    => array('has_many',   'model' => 'Impro\Post\Survey\Answer'),
			'votes'      => array('has_many',   'model' => 'Impro\Post\Survey\Vote'),

			'responses'  => array('has_many',   'model' => 'Impro\Post', 'foreign_name' => 'id_parent'),
			'parent'     => array('belongs_to', 'model' => 'Impro\Post', 'is_null' => true),

			'topic'      => array('belongs_to', 'model' => 'Impro\Discussion\Topic'),
			'team'       => array('belongs_to', 'model' => 'Impro\Team'),
			'team_topic' => array('belongs_to', 'model' => 'Impro\Team\Discussion\Topic'),
			'event'      => array('belongs_to', 'model' => 'Impro\Event'),
			'author'     => array('belongs_to', 'model' => 'System\User'),
		);

		protected static $access = array(
			'schema' => true,
			'browse' => true,
			'view' => true,
		);


		public function get_user()
		{
			return $this->user;
		}


		/** Check if current user has voted
		 * @return bool
		 */
		public function voted(\System\User $user)
		{
			if ($this->type == self::SURVEY) {
				return !!$this->votes->where(array('id_user' => $user->id))->count();
			} else throw new \System\Error\Model(sprintf('Post #%s is not typed as survey!', $this->id));
		}
	}
}
