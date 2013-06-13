<?

namespace System\User\Auth
{
	class Code extends \System\Model\Database
	{
		const KEY_LENGTH = 128;

		private static $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~';

		protected static $attrs = array(
			"key"      => array('varchar', "is_unique" => true, "length" => self::KEY_LENGTH),
			"uid"      => array('varchar', "is_index" => true),
			"due"      => array('datetime', "is_null" => true),
			"used"     => array('int', "default" => 0),
			"one_time" => array('bool', "default" => false),
			"user"     => array('belongs_to', "model" => '\System\User'),
		);


		/** Generate new key for user
		 * @param \System\User $user
		 * @param \DateTime    $due
		 * @return self
		 */
		public static function generate(\System\User $user, \DateTime $due = null, $one_time = false)
		{
			$obj = new self(array(
				"id_user"  => $user->id,
				"uid"      => self::generate_uid($user->id),
				"key"      => self::generate_str($user->id),
				"due"      => $due,
				"one_time" => $one_time,
			));

			return $obj->save();
		}


		public static function validate($key, $uid)
		{
			$code = get_first('\System\User\Auth\Code')->where(array("key" => $key, "uid" => $uid))->fetch();

			if ($code) {
				if ($code->used == 0 || !$code->one_time) {
					$code->used = $code->used + 1;

					if ($code->one_time) {
						$code->drop();
					} else $code->save();

					return $code;
				} else $code->drop();
			}

			return false;
		}


		private static function generate_str($id_user)
		{
			$key  = '';
			$fix  = sha1('{'.rand(100000000, 999999999).'-'.time().'-'.$id_user.'-'.rand(100000000, 999999999).'}');
			$size = strlen(self::$chars);

			for ($i = strlen($fix); $i < self::KEY_LENGTH; $i++) {
				$key .= self::$chars[rand(0, $size - 1)];
			}

			return $fix.'.'.$key;
		}


		private static function generate_uid($id_user)
		{
			return sha1('{'.rand(100000000, 999999999).'-'.$id_user.'-'.rand(100000000, 999999999).'}');
		}
	}
}
