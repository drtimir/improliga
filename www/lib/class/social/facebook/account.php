<?

namespace Social\Facebook {

	class Account extends \System\Model\Database
	{
		protected static $attrs = array(
			"user"         => array('belongs_to', "model" => '\System\User', "is_null" => true),
			"facebook_id"  => array('int', "is_unsigned" => true, "is_unique" => true),
			"email"        => array('varchar', "is_null" => true),
			"username"     => array('varchar', "default" => ''),
			"first_name"   => array('varchar', "default" => ''),
			"middle_name"  => array('varchar', "default" => ''),
			"last_name"    => array('varchar', "default" => ''),
			"locale"       => array('varchar', "is_null" => true),
			"timezone"     => array('int'),
			"birthday"     => array('datetime', "is_null" => true),
			"last_seen_at" => array('datetime', "is_null" => true),
			"verified"     => array('bool', "default" => true),
		);
	}
}
