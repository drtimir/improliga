<?

namespace Godmode
{
	class Icon
	{
		private static $banned = array(
			'godmode/24/default.png',
		);

		public static function get_list()
		{
			$icons = array();
			$files = array();

			\System\Directory::find_all_files(ROOT.\System\Template::DIR_ICONS.'/godmode/24', $files, $regexp = "/\.png$/");
			$start = strlen(ROOT.\System\Template::DIR_ICONS)+1;

			foreach ($files as $file) {
				$file = substr($file, $start);

				if (!in_array($file, self::$banned)) {
					$icon = explode('/', $file, 3);
					$icons[] = '/share/icons/'.implode('/', array($icon[1], $icon[0], $icon[2]));
				}
			}

			return $icons;
		}
	}
}
