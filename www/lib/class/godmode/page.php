<?

namespace Godmode
{
	class Page extends \System\Page
	{
		const DIR_MENU = "/etc/godmode/menu-main.d";
		const DIR_SUBMENU = "/etc/godmode/menu-modules.d";
		const DIR_ROUTES = "/etc/godmode/routes";

		private static $routes = array();
		private static $menu   = array();
		private static $env    = 'default';


		public static function fetch($attempts = 0)
		{
			$path = str_replace('god/', '', \System\Input::get('path'));
			if($attempts > 3) die('Heavy code bug!');

			$iter = &self::$routes;
			$attempts ++;

			if (any($iter)) {
				$path = array_filter(explode('/', $path));
				$pd = self::browse_tree($iter, $path);

				if ($pd[1]['found']) {
					$pd['page_path'] = $path;
					$page = new self($pd[0]);

					if ($page->template) {
						$page->fill_template();
					}

					$page->add_modules();
					return $page;
				}
			} else throw new \InternalException(l('No pages found. The setup routes file must be broken.'));
		}


		/** Does godmode environment exist
		 * @return bool
		 */
		public static function env_exists($env)
		{
			return is_dir(self::get_env_path($env));
		}


		/** Assemble path to config
		 * @return string
		 */
		public static function get_env_path($env)
		{
			return ROOT.self::DIR_ROUTES.'/'.$env.'.d';
		}


		/** Autoinit class variables
		 * @return void
		 */
		public static function init()
		{
			if (self::env_exists(self::$env)) {
				self::$routes = json_decode(file_get_contents(ROOT.self::DIR_ROUTES.'/root.json'), true);
				\System\Json::read_dist(self::get_env_path(self::$env), self::$routes, true);
				\System\Json::read_dist(ROOT.self::DIR_MENU, self::$menu);

				self::trans_menu(self::$menu);
				self::sort_menu_data();
			} else throw new \MissingFileException(sprintf(l("Directory not found: %s"), self::get_env_path(self::$env)));
		}


		private static function trans_menu(&$menu)
		{
			foreach ($menu as &$m) {
				$m['name'] = l($m['name']);

				if (isset($m['items'])) {
					self::trans_menu($m['items']);
				}
			}
		}


		/** Get menu data
		 * @return array
		 */
		public static function get_menu_data()
		{
			return self::$menu;
		}


		/** Sort menu data by locales
		 * @return void
		 */
		private static function sort_menu_data()
		{
			//~ usort(self::$menu, array("\Godmode\Page", 'sort_menu_data_helper'));
			//~ foreach (self::$menu as &$section) {
				//~ usort($section['items'], array("\Godmode\Page", 'sort_menu_data_helper_inner'));
			//~ }
		}


		/** Helper to sort godmode menu sections
		 * @return void
		 */
		public static function sort_menu_data_helper($a, $b)
		{
			$c = strcoll(l($a['name']), l($b['name']));
			return $c === 0 ? 0:($c < 0 ? -1:1);
		}


		/** Helper to sort godmode menu modules
		 * @return void
		 */
		public static function sort_menu_data_helper_inner($a, $b)
		{
			$c = strcoll(l($a[2]), l($b[2]));
			return $c === 0 ? 0:($c < 0 ? -1:1);
		}
	}
}
