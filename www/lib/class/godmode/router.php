<?

namespace Godmode
{
	abstract class Router
	{
		const DIR_ADMIN  = '/etc/godmode/admin.d';
		const DIR_MENU   = '/etc/godmode/menu.d';
		const DIR_ROUTES = '/etc/godmode/routes.d';
		const FILE_ROUTES_CACHE = '/var/cache/godmode';

		private static $routes = array();
		private static $menu   = array();


		public static function init()
		{
			if (!logged_in()) {
				if (\System\Input::get('path') != '/god/login/') {
					redirect_now('/god/login');
				}
			}

			self::load_routes();
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
				self::$routes = &$data['routes'];
				self::$menu   = &$data['menu'];
			} else return self::build_routes();
		}


		public static function build_routes()
		{
			$dist = \System\Json::read_dist(ROOT.self::DIR_ADMIN);
			self::$routes = \System\Json::read_dist(ROOT.self::DIR_ROUTES);
			self::read_dist_items($dist);
			self::save();
		}


		public static function save()
		{
			\System\File::put(ROOT.self::FILE_ROUTES_CACHE, json_encode(array(
				"routes" => self::$routes,
				"menu"   => self::$menu
			)));
		}


		public static function read_dist_items(&$items, $parent_item = null)
		{
			//~ v($items);
			foreach ($items as $item) {
				$item['level'] = any($parent_item) ? $parent_item['level']+1:0;
				$link = any($item['model']) ? \System\Loader::get_link_from_model($item['model']):$item['name'];

				if (any($parent_item)) {
					$item['target_menu']   = &$parent_item['target_menu'];
					$item['target_routes'] = &$parent_item['target_routes'][$link];
					$item['url']           = $parent_item['url'];
					$item['url'][]         = $link;
				} else {
					$item['target_menu']   = &self::$menu;
					$item['target_routes'] = &self::$routes[$link];
					$item['url']           = array('god', $link);
				}

				if (any($item['model'])) {
					$item['target_routes'] = self::get_model_admin($item);

					isset($item['window_root']) && $item['target_routes']['#']['window_root'] = true;
					isset($item['name']) && $item['target_routes']['#']['title'] = $item['name'];

				} else {
					$cfg = array();

					if (isset($item['window_root'])) {
						$cfg['window_root'] = true;
					}

					if (!isset($item['template'])) {
						$cfg['template'] = array('pwf/godmode/window');
					}

					$item['target_routes'] = array(
						'#' => $cfg,
					);
				}

				$menu_target = &$item['target_menu'][];
				$menu_target = array(
					"name"  => $item['name'],
					"icon"  => any($item['icon']) ? $item['icon']:'items/default',
					"url"   => '/' . implode('/', $item['url']) . '/',
				);


				if (any($item['items'])) {
					$menu_target['items'] = array();
					$item['target_menu'] = &$menu_target['items'];
					self::read_dist_items($item['items'], $item);
				}
			}
		}


		private static function get_model_admin(array $item)
		{
			$url_base   = implode('/', $item['url']);
			$link_cont  = '/'.$url_base.'/{'.\System\Model\Database::get_id_col(\System\Loader::get_class_from_model($item['model'])).'}/';
			$link_redir = '/'.$url_base.'/';

			$fragment = array(
				"#" => array(
					"icon"     => 'actions/list',
					"title"    => 'godmode_list',
					"template" => array('pwf/godmode/window'),
					"modules"  => array(
						array("godmode/admin/list", array(
							"model"      => $item['model'],
							"attrs_list" => any($item['attrs_list']) ? $item['attrs_list']:['id', 'get_name'],
							"link_cont"  => $link_cont,
						)),
					),
				),

				"create" => array(
					"#" => array(
						"icon"    => 'actions/create',
						"modules" => array(
							array("godmode/admin/edit", array(
								"model"      => $item['model'],
								"new"        => true,
								"attrs_edit" => any($item['attrs_edit']) ? $item['attrs_edit']:null,
								"attrs_edit_exclude" => any($item['attrs_edit_exclude']) ? $item['attrs_edit_exclude']:array(),
								"inline"     => any($item['inline']) ? $item['inline']:array(),
								"link_redir" => $link_redir,
							)),
						),
					),
				),

				"*" => array(
					"#" => array(
						"icon"    => 'actions/detail',
						"title"   => 'godmode_detail',
						"modules" => array(
							array('godmode/admin/detail', array(
								"id"    => '#{0}',
								"model" => $item['model'],
								"link_cont"    => $link_cont,
								"attrs_detail" => any($item['attrs_detail']) ? $item['attrs_detail']:null,
							)),
						),
					),

					"edit" => array(
						"#" => array(
							"icon"    => 'actions/edit',
							"modules" => array(
								array('godmode/admin/edit', array(
									"id"    => '#{0}',
									"model" => $item['model'],
									"attrs_edit" => any($item['attrs_edit']) ? $item['attrs_edit']:null,
									"attrs_edit_exclude" => any($item['attrs_edit_exclude']) ? $item['attrs_edit_exclude']:array(),
									"inline"     => any($item['inline']) ? $item['inline']:array(),
									"link_redir" => $link_redir,
								)),
							),
						),
					),

					"delete" => array(
						"#" => array(
							"icon"    => 'actions/delete',
							"modules" => array(
								array('godmode/admin/delete', array(
									"id"    => '#{0}',
									"model" => $item['model'],
									"attrs_edit" => any($item['attrs_edit']) ? $item['attrs_edit']:null,
									"link_redir" => $link_redir,
								)),
							),
						),
					),
				),
			);

			if (any($item['object_menu'])) {
				foreach ($item['object_menu'] as $item) {
					if (isset($item['modules'])) {
						foreach ($item['modules'] as &$mod) {
							$mod[1]['link_redir'] = $link_redir;
							$mod[1]['link_cont'] = $link_redir;
						}
					}

					$fragment['*'][$item['name']]['#'] = $item;
				}
			}

			return $fragment;
		}


		public static function page()
		{
			$path = str_replace('god/', '', \System\Input::get('path'));
			$iter = &self::$routes;

			if (any($iter)) {
				$path = array_filter(explode('/', $path));
				$pd = \System\Page::browse_tree($iter, $path);

				if ($pd) {
					$pd['page_path'] = $path;
					$page = new \System\Page($pd);
					\System\Page::set_current($page);

					$page->add_modules();
					return $page;
				} else throw new \System\Error\NotFound();
			} else throw new \System\Error(l('No pages found. Godmode routes must be broken.'));
		}


		public static function get_menu()
		{
			self::trans_menu(self::$menu);
			self::sort_menu();
			return self::$menu;
		}


		public static function get_window_menu()
		{
			$path_temp = array();
			$path_str = str_replace('god/', '', \System\Input::get('path'));
			$path = array_filter(explode('/', $path_str));
			$menu = array();
			$menu_paths = array();

			foreach ($path as $part) {
				$menu[] = null;
				$path_temp[] = $part;
				self::add_window_menu_items($path_temp, $menu, $menu_paths);
			}

			$l = last($menu);
			if (is_null($l)) {
				unset($menu[count($menu)-1]);
			}

			return $menu;
		}


		private static function add_window_menu_items($path, &$menu, &$menu_paths)
		{
			$iter = &self::$routes;

			if (any($iter)) {
				$pd = \System\Page::browse_tree($iter, $path, false);
				$path_str = '/'.implode('/', $path).'/';

				if ($pd) {
					if (isset($pd['#']['window_root'])) {
						$menu = array();
						$menu_paths = array();
					}

					if (isset($pd['#']['title'])) {
						$p = '/god'.$path_str;

						if (!in_array($p, $menu_paths)) {
							$menu_paths[] = $p;
							$menu[] = array($pd['#']['title'], $p, isset($pd['#']['icon']) ? $pd['#']['icon']:'default');
						}
					}

					foreach ($pd as $link=>$page) {
						$title = null;
						$break = false;

						if ($link !== '*') {
							if (isset($page['#'])) {

								if (isset($page['#']['title'])) {
									$title = $page['#']['title'];
								} else {
									if ($link == '*') {
										$title = 'godmode_detail';
									}
								}

								if (!$title) {
									$title = 'godmode_'.$link;
								}

								if (isset($page['#']['icon'])) {
									$icon = $page['#']['icon'];
								} else {
									$icon = 'default';
								}

								$p = '/god'.$path_str.$link.'/';

								if (!in_array($p, $menu_paths)) {
									$menu_paths[] = $p;
									$menu[] = array($title, $p, $icon);
								}
							}
						}
					}
				}
			}
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
		private static function sort_menu()
		{
			usort(self::$menu, array("\Godmode\Router", 'sort_menu_data_helper'));
			foreach (self::$menu as &$section) {
				if (isset($section['items']) && any($section['items'])) {
					usort($section['items'], array("\Godmode\Router", 'sort_menu_data_helper'));
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
	}
}
