<?

namespace Godmode
{
	abstract class Admin
	{
		public static function get_banned_attrs($model)
		{
			return array(\System\Model\Database::get_id_col($model), 'created_at', 'updated_at');
		}


		public static function get_attr_list(\System\Model\Database $item, array $attrs_edit, array $attrs_edit_exclude)
		{
			$model = get_class($item);
			$attrs = array();
			$banned_attrs = self::get_banned_attrs($model);

			if (empty($attrs_edit)) {
				$attrs_edit = \System\Model\Database::get_model_attr_list($model);
				$attrs_edit = array_merge($attrs_edit, \System\Model\Database::get_location_attrs($model));
			}

			foreach ($attrs_edit as $alias=>$attr) {
				if (!is_numeric($alias)) {
					$attr = $alias;
				}

				if ($item->has_attr($attr)) {
					$def = \System\Model\Database::get_attr($model, $attr);

					if ($def[0] != 'password' && !in_array($attr, $banned_attrs) && !in_array($attr, $attrs_edit_exclude) && !\System\Model\Database::is_model_belongs_to_id($model, $attr)) {
						$attrs[$attr] = $def;
						$attrs[$attr]['type'] = 'attr';
					}
				} elseif (\System\Model\Database::get_rel_type($model, $attr) === 'belongs-to') {
					$def = \System\Model\Database::get_rel_def($model, $attr);
					if (\System\Loader::get_link_from_class($def['model']) === 'system_location') {
						$attrs[$attr] = $def;
						$attrs[$attr]['type'] = 'belongs-to';
					}
				}
			}

			return $attrs;
		}
	}
}
