<?

namespace Godmode
{
	abstract class Router
	{
		const DIR_ADMIN  = '/etc/godmode/admin.d';
		const DIR_MENU   = '/etc/godmode/menu.d';
		const DIR_ROUTES = '/etc/godmode/routes.d';
		const FILE_ROUTES_CACHE = '/var/cache/godmode';

		const LINK_HOME  = 'god_home';
		const LINK_MODEL = 'god_%s_%s';

		const PATH_MODEL         = '/model/%s/$';
		const PATH_MODEL_ACTION  = '/model/%s/%s/$';
		const PATH_OBJECT        = '/model/%s/([^/]+)/$';
		const PATH_OBJECT_ACTION = '/model/%s/([^/]+)/%s/$';

		const TEMPLATE_WINDOW = 'pwf/godmode/window';

		private static $routes      = array();
		private static $menu        = array();
		private static $window_menu = array();


		public static function init()
		{
			self::load_routes();

			foreach (cfg('godmode', 'domains') as $domain) {
				try {
					\System\Router::get_url($domain, self::LINK_HOME);
				} catch(\System\Error\Argument $e) {

					// Inject routes into domain urls
					$routes = cfg('routes', $domain);

					foreach (self::$routes as $route) {
						$routes[] = $route;
					}

					cfgs(array('routes', $domain), $routes);
				}
			}

			//~ v(self::$menu);
			//~ v(\System\Router::get_named_routes());
		}


		public static function load_routes()
		{
			if (file_exists($f=ROOT.self::FILE_ROUTES_CACHE)) {
				$files = \System\Directory::find(ROOT.self::DIR_ADMIN, '/\.json$/');
				$mtime = filemtime($f);

				foreach ($files as $file) {
					if (filemtime($file) > $mtime) {
						return self::build_routes();
					}
				}

				$files = \System\Directory::find(ROOT.self::DIR_MENU, '/\.json$/');
				foreach ($files as $file) {
					if (filemtime($file) > $mtime) {
						return self::build_routes();
					}
				}

				$data = \System\Json::read(ROOT.self::FILE_ROUTES_CACHE);
				self::$routes      = &$data['routes'];
				self::$menu        = &$data['menu'];
				self::$window_menu = &$data['window_menu'];
			} else return self::build_routes();
		}


		public static function build_routes()
		{
			$dist = \System\Json::read_dist(ROOT.self::DIR_ADMIN);
			self::$routes = \System\Json::read_dist(ROOT.self::DIR_ROUTES);
			self::read_dist_items($dist);

			// Add godmode path prefix
			foreach (self::$routes as &$route) {
				$route[0] = cfg('godmode', 'path_prefix').$route[0];
			}

			self::save();
		}


		public static function save()
		{
			\System\File::put(ROOT.self::FILE_ROUTES_CACHE, json_encode(array(
				"routes"      => self::$routes,
				"menu"        => self::$menu,
				"window_menu" => self::$window_menu,
			)));
		}


		public static function read_dist_items(&$items, $parent_item = null)
		{
			foreach ($items as $item) {
				$item['level'] = any($parent_item) ? $parent_item['level']+1:0;
				$link = any($item['model']) ? \System\Loader::get_link_from_model($item['model']):$item['name'];

				if (any($parent_item)) {
					$item['target_menu']   = &$parent_item['target_menu'];
					$item['url_name']      = $parent_item['url_name'];
					$item['url_name'][]    = $link;
				} else {
					$item['target_menu']   = &self::$menu;
					$item['url_name']      = array($link);
				}

				$menu_url_name = null;

				if (any($item['model'])) {
					$model_routes = self::get_model_admin($item, $item['url_name']);

					foreach ($model_routes as $route) {
						if (is_null($menu_url_name)) {
							$menu_url_name = $route[2];
							self::$window_menu[$route[2]] = array();
							$menu_target = &self::$window_menu[$route[2]];
						}

						if (isset($item['window_root'])) {
							$route[1]['window_root'] = true;
						}

						if (isset($item['title']) && empty($route[1]['title'])) {
							$route[1]['title'] = $item['title'];
						}

						self::$routes[] = $route;

						if (isset($route[1]['separator'])) {
							$menu_target[] = null;
						}

						$menu_target[] = array(
							"title"       => $route[1]['title'],
							"icon"        => $route[1]['icon'],
							"url_pattern" => $route[0],
							"url_name"    => $route[2],
						);
					}

				} else {
					if (isset($item['modules'])) {
						$cfg = array();

						if (isset($item['window_root'])) {
							$cfg['window_root'] = true;
						}

						if (!isset($item['template'])) {
							$cfg['layout'] = array(self::TEMPLATE_WINDOW);
						}

						self::$routes[] = $cfg;
					}
				}

				$mt = &$item['target_menu'][];
				$mt = array(
					"name"  => $item['title'],
					"icon"  => any($item['icon']) ? $item['icon']:'items/default',
					"url"   => $menu_url_name,
				);


				if (any($item['items'])) {
					$mt['items'] = array();
					$item['target_menu'] = &$mt['items'];
					self::read_dist_items($item['items'], $item);
				}
			}
		}


		private static function get_model_admin(array $item, array $link)
		{
			$link_path = implode('/', $link);
			$link_name = implode('_', $link);

			if (strpos($item['model'], '\\') !== 0) {
				$item['model'] = '\\'.$item['model'];
			}

			$fragment = array(
				array(sprintf(self::PATH_MODEL, $link_path), array(
					"icon"     => 'actions/list',
					"title"    => 'godmode_list',
					"layout"   => array(self::TEMPLATE_WINDOW),
					"no_debug" => true,
					"title"    => 'godmode_model_object_list',
					"modules"  => array(
						array("godmode/window/menu", array("slot" => 'menu', "model" => $item['model'])),
						array("godmode/admin/list", array(
							"model"      => $item['model'],
							"sort"       => any($item['sort']) ? $item['sort']:null,
							"attrs_list" => any($item['attrs_list']) ? $item['attrs_list']:array('id', 'get_name'),
							"link_god"   => $link,
						)),
					),
				), sprintf(self::LINK_MODEL, $link_name, 'list')),

				array(sprintf(self::PATH_MODEL_ACTION, $link_path, 'create'), array(
					"icon"     => 'actions/create',
					"layout"   => array(self::TEMPLATE_WINDOW),
					"no_debug" => true,
					"title"    => 'godmode_model_object_new',
					"modules" => array(
						array("godmode/window/menu", array("slot" => 'menu', "model" => $item['model'])),
						array("godmode/admin/edit", array(
							"model"      => $item['model'],
							"new"        => true,
							"attrs_edit" => any($item['attrs_edit']) ? $item['attrs_edit']:null,
							"attrs_edit_exclude" => any($item['attrs_edit_exclude']) ? $item['attrs_edit_exclude']:array(),
							"rel_inline" => any($item['rel_inline']) ? $item['rel_inline']:array(),
							"rel_pick"   => any($item['rel_inline']) ? $item['rel_inline']:array(),
							"rel_tab"    => any($item['rel_tab']) ? $item['rel_tab']:array(),
							"link_god"   => $link,
						)),
					),
				), sprintf(self::LINK_MODEL, $link_name, 'create')),

				array(sprintf(self::PATH_OBJECT, $link_path), array(
					"icon"      => 'actions/detail',
					"title"     => 'godmode_detail',
					"layout"    => array(self::TEMPLATE_WINDOW),
					"no_debug"  => true,
					"title"     => 'godmode_model_object_detail',
					"separator" => true,
					"modules"   => array(
						array("godmode/window/menu", array("slot" => 'menu', "model" => $item['model'])),
						array('godmode/admin/detail', array(
							"id"    => '#{0}',
							"model" => $item['model'],
							"attrs_detail" => any($item['attrs_detail']) ? $item['attrs_detail']:null,
							"link_god"   => $link,
						)),
					),
				), sprintf(self::LINK_MODEL, $link_name, 'detail')),

				array(sprintf(self::PATH_OBJECT_ACTION, $link_path, 'edit'), array(
					"icon"     => 'actions/edit',
					"no_debug" => true,
					"layout"   => array(self::TEMPLATE_WINDOW),
					"title"    => 'godmode_model_object_edit',
					"modules" => array(
						array("godmode/window/menu", array("slot" => 'menu', "model" => $item['model'])),
						array('godmode/admin/edit', array(
							"id"    => '#{0}',
							"model" => $item['model'],
							"attrs_edit" => any($item['attrs_edit']) ? $item['attrs_edit']:null,
							"attrs_edit_exclude" => any($item['attrs_edit_exclude']) ? $item['attrs_edit_exclude']:array(),
							"rel_inline" => any($item['rel_inline']) ? $item['rel_inline']:array(),
							"rel_pick"   => any($item['rel_pick']) ? $item['rel_pick']:array(),
							"rel_tab"    => any($item['rel_tab']) ? $item['rel_tab']:array(),
							"link_god"   => $link,
						)),
					),
				), sprintf(self::LINK_MODEL, $link_name, 'edit')),

				array(sprintf(self::PATH_OBJECT_ACTION, $link_path, 'delete'), array(
					"icon"     => 'actions/delete',
					"layout"   => array(self::TEMPLATE_WINDOW),
					"no_debug" => true,
					"title"    => 'godmode_model_object_delete',
					"modules"  => array(
						array("godmode/window/menu", array("slot" => 'menu', "model" => $item['model'])),
						array('godmode/admin/delete', array(
							"id"    => '#{0}',
							"model" => $item['model'],
							"attrs_edit" => any($item['attrs_edit']) ? $item['attrs_edit']:null,
							"link_god"   => $link,
						)),
					),
				), sprintf(self::LINK_MODEL, $link_name, 'delete')),
			);

			if (any($item['object_menu'])) {
				foreach ($item['object_menu'] as $menu_item) {
					$menu_item['layout'] = array(self::TEMPLATE_WINDOW);
					$menu_item['no_debug'] = true;

					if (!isset($menu_item['modules'])) {
						$menu_item['modules'] = array();
					} else {
						foreach ($menu_item['modules'] as &$module) {
							if (!isset($module[1])) {
								$module[1] = array();
							}

							$module[1]['link_god'] = $link;
						}
					}

					array_unshift($menu_item['modules'], array("godmode/window/menu", array("slot" => 'menu', "model" => $item['model'])));

					$fragment[] = array(
						sprintf(self::PATH_OBJECT_ACTION, $link_path, $menu_item['name']),
						$menu_item,
						sprintf(self::LINK_MODEL, $link_name, $menu_item['name'])
					);
				}
			}

			return $fragment;
		}


		public static function get_menu(\System\Http\Request $request)
		{
			self::trans_menu(self::$menu);
			$menu = self::$menu;

			self::link_menu($request, $menu);
			self::sort_menu($menu);
			return $menu;
		}


		public static function get_window_menu(\System\Http\Request $request)
		{
			$path_temp = array();
			$prefix = str_replace('/', '\\/', cfg('godmode', 'path_prefix'));
			$path_str = preg_replace('/'.$prefix.'/', '', $request->path);
			$menu_temp = array();
			$menu = array(null);

			foreach (self::$window_menu as $key=>$items) {
				foreach ($items as &$item) {
					if (!is_null($item)) {
						if (preg_match('/'.$prefix.str_replace('/', '\\/', $item['url_pattern']).'/', $request->path)) {
							$item['selected'] = true;
							$menu_temp = $items;
							break;
						}
					}
				}
			}

			foreach ($menu_temp as $item) {
				try {
					if (!is_null($item)) {
						$item['url'] = $request->url($item['url_name'], $request->args);
					}

					$menu[] = $item;
				} catch (\Exception $e) {}
			}

			return $menu;
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


		/** Sort menu data by locales
		 * @return void
		 */
		private static function sort_menu(&$menu)
		{
			usort($menu, array("\Godmode\Router", 'sort_menu_data_helper'));
			foreach ($menu as &$section) {
				if (isset($section['items']) && any($section['items'])) {
					self::sort_menu($section['items']);
				}
			}
		}


		/** Helper to sort godmode menu sections
		 * @return void
		 */
		public static function sort_menu_data_helper($a, $b)
		{
			$c = strcoll(l($a['name']), l($b['name']));
			return $c === 0 ? 0:($c < 0 ? -1:1);
		}


		private static function link_menu(\System\Http\Request $request, array &$items)
		{
			foreach ($items as &$section) {
				if (isset($section['url']) && any($section['url'])) {
					$section['url'] = \System\Router::get_url($request->host, $section['url']);
					//~ v($section);
					//~ exit;
				}

				if (isset($section['items'])) {
					self::link_menu($request, $section['items']);
				}
			}
		}


		public static function url(\System\Http\Request $request, array $link_god, $action = 'list', array $args = array())
		{
			return \System\Router::get_url($request->host, sprintf(self::LINK_MODEL, implode('_', $link_god), $action), $args);
		}


		public static function entered(\System\Http\Request $request)
		{
			return \System\Router::json_preg_match(cfg('godmode', 'path_prefix'), $request->path);
		}
	}
}
