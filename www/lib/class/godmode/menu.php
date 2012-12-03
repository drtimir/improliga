<?

namespace Godmode
{
	class Menu extends \System\Model\Attr
	{
		protected static $attrs  = array(
			"name"     => array('varchar'),
			"visible"  => array('bool'),
			"deleted"  => array('bool'),
		);

		private $related = array();
		private $items = array();
		private $type;
		private $hiearchy;
		private $path = array();


		public static function create(array $opts)
		{
			def($opts['type'], 'menu');
			if ($opts['type'] == 'admin-menu') {
				$menu = new self();
				$menu->path = $opts['menu-path'] ? array_filter(explode('/', $opts['menu-path'])):NULL;
				$menu->type = $opts['type'];
				$file = $menu->path[0];

				$menu->load_from_file(ROOT.\Godmode\Page::DIR_SUBMENU.'/'.$file.'.json');
			} elseif (($id = $opts['id']) || $id = $opts[self::$id_col]) {
				$menu = find("\System\Menu", $id);
			} else {
				$menu = new self($opts);
			}

			return $menu;
		}


		public function load_from_file($url)
		{
			$tree = json_decode(@file_get_contents($url), true);
			$am = $this->type == 'admin-menu';
			$path = $am ? array('', 'god'):array();

			$this->hiearchy = array('*' => $tree);
			$iter = &$this->hiearchy;

			foreach ((array) $this->path as $p) {
				if (isset($iter[$p]) && is_array($iter[$p])) {
					$path[] = $p;
					$this->process_items($iter[$p], $path);
					$iter = &$iter[$p];
				} elseif(isset($iter['*']) && is_array($iter['*'])) {
					$path[] = $p;
					$this->process_items($iter['*'], $path);
					$iter = &$iter['*'];
				}
			}
		}


		private function process_items(array $items, $path)
		{
			if (isset($items['menu'])) {
				foreach ($items['menu'] as $m) {
					if (is_string($m) && $m === 'drop') {
						$this->items = array();
					} else {
						if (is_array($m)) {
							self::fix_path($m, $path);
						}

						$this->items[] = $m;
					}
				}
			}

			!empty($items['related']) && $this->related = array_merge($this->related, (array) $items['related']);
		}


		private static function fix_path(array &$item, $path = null)
		{
			$prefix = self::fix_prefix((is_array($path) ? implode('/', $path):$path).'/');

			if (preg_match("/^\.\//", $item[1]) && $item[1] != './') {
				$item[1] = $prefix.substr($item[1], 2);
			} elseif($item[1] == './') {
				$item[1] = $prefix.$item[1];
			}
		}


		public function get_items()
		{
			return $this->items;
		}


		public function get_related()
		{
			return $this->related;
		}


		public function get_type()
		{
			return $this->type;
		}



		private static function fix_prefix($prefix)
		{
			return implode('/', array_map('urlencode', explode('/', $prefix)));
		}
	}
}
