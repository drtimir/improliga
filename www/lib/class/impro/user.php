<?

namespace Impro
{
	abstract class User
	{
		public static function signature(\System\User $user)
		{
			return \Tag::div(array(
				"class"   => 'signature',
				"content" => array(
					self::avatar($user),
					self::link($user),
				),
			));
		}


		public static function avatar(\System\User $user, $w = 40, $h = 40)
		{
			return link_for(\Tag::img(array(
				"output" => false,
				"src"    => $user->avatar->thumb($w, $h),
				"alt"    => '',
			)));
		}


		public static function link(\System\User $user)
		{
			return link_for($user->get_name(), '/profile/'.$user->id.'/');
		}
	}
}
