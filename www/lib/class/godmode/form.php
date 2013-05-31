<?

namespace Godmode
{
	class Form
	{
		public static function add_rel_edit(&$f, $model, $rel, array $objects)
		{
			$locales = $f->response()->locales();
			$type  = \System\Model\Database::get_rel_type($model, $rel);
			$def   = \System\Model\Database::get_rel_def($model, $rel);
			$attrs = \System\Model\Database::get_attr_def($def['model']);
			$objects[] = new $def['model']();
			$noshow = array('created_at', 'updated_at', \System\Model\Database::get_id_col($model), \System\Model\Database::get_id_col($def['model']));
			$x = 0;

			foreach ($objects as $key=>$obj) {
				$group_name = $obj->id ? 'obj_'.$obj->id:'obj_add_'.$x;
				$cname = $locales->trans_class_name($def['model']);
				$label = $obj->id ? $locales->trans('godmode_model_object', $cname, $obj->id):$locales->trans('godmode_model_object_new', strtolower($cname));
				$f->group_start('inputs', $group_name, $label);

				foreach ($attrs as $attr=>$attr_def) {
					if (!in_array($attr, $noshow)) {
						$required = !(isset($attr_def['is_null']) || isset($attr_def['default']));
						if ($obj->id) {
							$name = $rel.'['.$obj->id.']['.$attr.']';
						} else {
							$name = $rel.'[add]['.$x.']['.$attr.']';
						}

						if ($attr_def[0] === 'bool') {
							$required = false;
						}

						if (isset($attr_def['options'])) {
							$options = \System\Model\Database::get_model_attr_options($def['model'], $attr);
							$opts = array();

							foreach ($options as $val=>$label) {
								$opts[$val] = $locales->trans($label);
							}

							$f->input(array(
								"label"    => $locales->trans_model_attr_name($def['model'], $attr),
								"name"     => $name,
								"type"     => 'select',
								"options"  => $opts,
								"value"    => $obj->$attr,
							));
						} else {
							$f->input(array(
								"type"     => \System\Form::get_field_type($attr_def[0]),
								"label"    => $locales->trans_model_attr_name($def['model'], $attr),
								"name"     => $name,
								"value"    => $obj->$attr,
							));
						}
					}
				}

				if ($obj->id) {
					$f->input_checkbox($rel.'['.$obj->id.'][delete]', $locales->trans('delete'));
				}

				$x++;
			}
		}


		public static function get_attr_options(\System\Template\Renderer $ren, $model, $attr, $def)
		{
			$options = array();

			if (isset($def['options'][0]) && $def['options'][0] = 'callback') {
				$callback = array();

				foreach ($def['options'] as $key=>$callback_part) {
					if ($key !== 0) {
						$callback[] = $callback_part;
					}
				}

				if (is_callable($callback)) {
					$options = call_user_func($callback);

				} else throw new \System\Error\Format(sprintf('Invalid callback for options of attribute %s of model %s', $attr, $model));


			} else {
				foreach ($def['options'] as $oid=>$olabel) {
					$options[$oid] = $ren->locales()->trans($olabel);
				}
			}

			return $options;
		}
	}
}
