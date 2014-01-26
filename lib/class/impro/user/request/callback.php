<?

namespace Impro\User\Request
{
	interface Callback
	{
		public static function yes(\Impro\User\Request $req);
		public static function no(\Impro\User\Request $req);
		public static function maybe(\Impro\User\Request $req);
	}
}
