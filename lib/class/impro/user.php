<?

namespace Impro
{
	abstract class User
	{
		private static $default = array(
			"groups" => array(3),
		);


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


		public static function avatar(\System\Template\Renderer $ren, \System\User $user, $w = 40, $h = 40)
		{
			return $ren->link_for('profile_user', $user->avatar->to_html($ren, $w, $h), array("args" => array($user)));
		}


		public static function link(\System\Template\Renderer $ren, \System\User $user)
		{

			return $ren->link_for('profile_user', self::get_name($user), array("args" => array($user), "class" => 'link-profile'));
		}


		public static function get_name(\System\User $user)
		{
			$name = $user->nick ? $user->nick:$user->get_name();
			return $name ? $name:$user->login;
		}


		public static function contact_to_html(\System\Template\Renderer $ren, \System\User\Contact $contact)
		{
			return div('user_contact', array(
				$ren->icon('impro/contact/'.$contact->get_type_name(), 16),
				span('contact_part contact_ident', $contact->ident),
				$contact->name ? span('contact_part contact_name', '('.$contact->name.')'):'',
			));
		}


		public static function get_default_data()
		{
			return self::$default;
		}


		public static function load_members(\System\User $user)
		{
			if (is_null($user->members)) {
				$user->members = get_all('\Impro\Team\Member')->where(array("id_system_user" => $user->id))->fetch();
				$teams = array();

				foreach ($user->members as $mem) {
					$teams[] = $mem->team;
				}

				$user->teams = $teams;
			}
		}


		//~ public static function notify(\System\User $user,)

		public static function create(\System\Template\Renderer $ren, \System\User $author, $mail)
		{
			$pass = \System\User::gen_passwd();
			$u = create('\System\User', array("login" => $mail, "password" => hash_passwd($pass)));
			$c = create('\System\User\Contact', array(
				"ident" => $mail,
				"name"  => 'výchozí',
				"type"  => \System\User\Contact::STD_EMAIL,
				"spam"  => true,
				"visible" => true,
				"id_user" => $u->id,
			));

			$notice = \Impro\User\Notice::for_user($u, array(
				"text"         => stprintf($ren->trans('intra_user_registration'), array(
					"login"    => $mail,
					"password" => $pass,
				)),
				"redirect"     => $ren->uri('profile_settings'),
				"generated_by" => 'system',
				"id_author"    => $author->id,
			));

			$notice->mail($ren->locales());
			return $u;
		}
	}
}
