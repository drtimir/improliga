<?

namespace Godmode
{
	class Editor
	{
		private $data_default = array();
		private $inputs = array();
		private $object;
		private $model;
		private $cfg;
		private $ren;
		private $f;
		private $rels;
		private $attrs;


		/** Create editor for object
		 * @param \System\Template\Renderer $ren
		 * @param \System\Model\Database    $object
		 * @param array                     $cfg
		 * @return \Godmode\Editor
		 */
		public static function for_object(\System\Template\Renderer $ren, \System\Model\Database $object, array $cfg = array())
		{
			$ed = new self();
			$ed->object = $object;
			$ed->model  = get_class($object);
			$ed->cfg    = $cfg;
			$ed->ren    = $ren;

			def($ed->cfg['picker'], array());
			def($ed->cfg['manager'], array());
			def($ed->cfg['attrs_edit'], null);
			def($ed->cfg['extra_buttons'], true);

			$ed
				->collect_data()
				->create_form()
				->attach_inputs();

			return $ed;
		}


		/** Collect data from given config
		 * @return $this
		 */
		private function collect_data()
		{
			$x = 0;
			$inline_has_many = array();
			$rel_data  = array();
			$rels      = array();
			$default   = $this->object->get_data();
			$attrs     = $this->get_attr_list();

			// Add relation pick data
			foreach ($this->cfg['picker'] as $rel) {
				if (\System\Model\Database::is_rel($this->model, $rel)) {
					$default[$rel] = collect_ids($this->object->$rel->fetch());
					$rels[$rel] = 'pick';
				} else throw new \System\Error\Format(sprintf('Cannot use picker for "%s". It is not model relation of any kind.', $rel));
			}

			// Add relation tab data
			foreach ($this->cfg['manager'] as $rel) {
				if (\System\Model\Database::is_rel($this->model, $rel)) {
					$default[$rel] = $this->object->$rel->fetch();
					$rels[$rel] = 'manager';
				} else throw new \System\Error\Format(sprintf('Cannot manage "%s" in tabs. It is not model relation of any kind.', $rel));
			}

			$default['save_and_edit'] = true;
			$default['save_and_add'] = true;

			$this->data_default = $default;
			$this->rels = $rels;
			$this->attrs = $attrs;
			return $this;
		}


		/** Prepare form object
		 * @return $this
		 */
		private function create_form()
		{
			$this->f = $this->ren->form(array(
				"default" => $this->data_default,
				"heading" => def($this->cfg['heading'], ''),
				"desc"    => def($this->cfg['desc'], ''),
				"class"   => array(
					'editor',
					'model_edit',
					'model_edit_'.\System\Loader::get_link_from_class($this->model)
				),
			));

			return $this;
		}


		/** Attach all inputs to the form
		 * @return $this
		 */
		private function attach_inputs()
		{
			return $this
				->attach_attr_inputs()
				->attach_manager_inputs()
				->attach_picker_inputs()
				->finalize_form();
		}


		private function tabs_necessary()
		{
			$attrs_and_rels = count($this->rels) > 1 && any($this->attrs);
			$more_rels = count($this->rels) > 1;

			return $attrs_and_rels || $more_rels;
		}


		/** Attach basic attribute inputs
		 * @return $this
		 */
		private function attach_attr_inputs()
		{
			if (any($this->attrs)) {
				if ($this->tabs_necessary()) {
					$this->f->tab($this->ren->locales()->trans('godmode_model_basic_attrs'));
				}

				foreach ($this->attrs as $attr=>$def) {
					$required = !(isset($def['is_null']) || isset($def['default']));

					if ($def['type'] === 'attr') {
						if (\System\Model\Database::is_rel($this->model, $attr)) {
							if ($def[0] === \System\Model\Database::REL_BELONGS_TO) {
								$attr = \System\Model\Database::get_belongs_to_id($this->model, $attr);
								$def  = \System\Model\Database::get_attr($this->model, $attr);
							} else {
								continue;
							}
						}

						$type = \System\Form::get_field_type($def[0]);

						if ($def[0] === 'bool') {
							$required = false;
						}

						if (in_array($attr, array('created_at', 'updated_at'))) {
							$name = $this->ren->locales()->trans($attr);
						} else {
							$name = $this->ren->locales()->trans_model_attr_name($this->model, $attr);
						}

						$input_options = array(
							"type"  => $type,
							"name"  => $attr,
							"label" => $name,
							"required" => $required,
						);

						if (isset($def['options'])) {
							$input_options['options'] = $this->get_attr_options($attr, $def);

							if (any($input_options['options'])) {
								$input_options['type'] = 'select';
							}
						}

						$this->f->input($input_options);
					} else {
						$link = \System\Loader::get_link_from_class($def['model']);

						if ($link === 'system_location') {
							$this->f->input_location($attr, $ren->locales()->trans_model_attr_name($this->model, $attr));
						} else {
							if (empty($all[$link])) {
								$all[$link] = get_all($def['model'])->fetch();
							}

							$this->f->input(array(
								"type" => 'select',
								"name" => \System\Model\Database::get_belongs_to_id($this->model, $attr),
								"options" => $all[$link],
								"label"   => $this->ren->locales()->trans_model_attr_name($this->model, $attr),
							));
						}
					}
				}
			}

			return $this;
		}


		/** Attach all relman inputs
		 * @return $this
		 */
		private function attach_manager_inputs()
		{
			foreach ($this->rels as $rel=>$rel_type) {
				if ($rel_type === 'manager') {
					$this->attach_rel_manager($rel);
				}
			}

			return $this;
		}


		/** Attach all picker inputs
		 * @return $this
		 */
		private function attach_picker_inputs()
		{
			foreach ($this->rels as $rel=>$rel_type) {
				if ($rel_type === 'pick') {
					$this->attach_picker($rel);
				}
			}

			return $this;
		}


		/** Attach relman
		 * @param string $relation Relation name
		 * @return this
		 */
		private function attach_rel_manager($rel)
		{
			$locales = $this->ren->locales();
			$type  = \System\Model\Database::get_attr_type($this->model, $rel);
			$def   = \System\Model\Database::get_attr($this->model, $rel);
			$attrs = \System\Model\Database::get_attr_def($def['model']);

			$objects = $this->data_default[$rel];
			$objects[] = new $def['model']();
			$x = 0;

			$noshow = $this->get_banned_attrs($def['model']);
			$noshow[] = \System\Model\Database::get_id_col($this->model);

			if ($this->tabs_necessary()) {
				$t = $this->f->tab($locales->trans_model_attr_name($this->model, $rel));
				$t->class_outer = 'relman';
			}

			foreach ($objects as $key=>$obj) {
				$group_name = $obj->id ? 'obj_'.$obj->id:'obj_add_'.$x;
				$cname = $locales->trans_class_name($def['model']);
				$label = $obj->id ?
					$locales->trans('godmode_model_object', $cname, $obj->id):
					$locales->trans('godmode_model_object_new', strtolower($cname));

				$group = $this->f->group_start('inputs', $group_name, $label);
				$group->class_outer = array('relman_object', $obj->id ? 'relman_object_'.$obj->id:'');

				foreach ($attrs as $attr=>$attr_def) {
					if (!empty($attr_def['is_generated'])) {
						continue;
					}

					if (\System\Model\Database::is_rel($def['model'], $attr)) {
						continue;
					}

					if (!in_array($attr, $noshow)) {
						$required = !(isset($attr_def['is_null']) || isset($attr_def['default']));
						if ($obj->id) {
							$name = sprintf('%s[%s][%s]', $rel, $obj->id, $attr);
						} else {
							$name = sprintf('%s[%s][%s][%s]', $rel, 'add', $x, $attr);
						}

						if ($attr_def[0] === 'bool') {
							$required = false;
						}

						$field_def = array(
							"label"    => $locales->trans_model_attr_name($def['model'], $attr),
							"name"     => $name,
							"type"     => \System\Form::get_field_type($attr_def[0]),
						);

						if ($obj->id) {
							$field_def["value"] = $obj->$attr;
						}

						if (isset($attr_def['options'])) {
							$options = \System\Model\Database::get_model_attr_options($def['model'], $attr);
							$opts = array();

							foreach ($options as $val=>$label) {
								$opts[$val] = $locales->trans($label);
							}

							$field_def['type'] = 'select';
							$field_def['options'] = $opts;
						}

						$this->f->input($field_def);
					}
				}

				if ($obj->id) {
					$del = $this->f->input_checkbox($rel.'['.$obj->id.'][delete]', $locales->trans('godmode_delete'));
					$del->class = 'relman_drop';
				}

				$x++;
			}

			return $this;
		}


		/** Attach picker
		 * @param string $relation Relation name
		 * @return this
		 */
		private function attach_picker($rel)
		{
			if ($this->tabs_necessary()) {
				$this->f->tab($this->ren->locales()->trans_model_attr_name($this->model, $rel));
			}

			$type = \System\Model\Database::get_attr_type($this->model, $rel);
			$def  = \System\Model\Database::get_attr($this->model, $rel);

			$models = get_all($def['model'])->fetch();

			$input_type = $type == \System\Model\Database::REL_HAS_MANY ? 'checkbox':'radio';

			$in = $this->f->input(array(
				"type"     => $input_type,
				"options"  => $models,
				"name"     => $rel,
				"multiple" => true,
				"label"    => $this->ren->locales()->trans_model_attr_name($this->model, $rel),
			));

			return $this;
		}


		/** Get list of banned attrs
		 * @param string $model Name of model
		 * @return array
		 */
		public function get_banned_attrs($model = null)
		{
			$model = is_null($model) ? $this->model:$model;
			return array(\System\Model\Database::get_id_col($model), 'created_at', 'updated_at', 'id_author', 'author');
		}


		/** Get list of attributes that will be edited
		 * @return array
		 */
		public function get_attr_list()
		{
			$attrs = array();
			$banned_attrs = self::get_banned_attrs($this->model);

			if (!isset($this->cfg['attrs_edit']) || !is_array($this->cfg['attrs_edit'])) {
				$this->cfg['attrs_edit'] = \System\Model\Database::get_model_attrs($this->model);
				$this->cfg['attrs_edit'] = array_merge($this->cfg['attrs_edit'], \System\Model\Database::get_location_attrs($this->model));
			}

			foreach ($this->cfg['attrs_edit'] as $alias=>$attr) {
				if (!is_numeric($alias)) {
					$attr = $alias;
				}

				if ($this->object->has_attr($attr)) {
					$def = \System\Model\Database::get_attr($this->model, $attr);

					if ($def[0] != 'password' && !in_array($attr, $banned_attrs) && !in_array($attr, $this->cfg['attrs_edit_exclude'])) {
						$attrs[$attr] = $def;
						$attrs[$attr]['type'] = 'attr';
					}
				}
			}

			return $attrs;
		}


		/** Add buttons and finish form preparation
		 * @return $this
		 */
		private function finalize_form()
		{
			$this->f->tab_group_end();
			$this->f->submit($this->ren->locales()->trans('godmode_save'));

			if ($this->cfg['extra_buttons']) {
				$this->f->input(array(
					"type"  => 'submit',
					"name"  => 'save_and_edit',
					"label" => $this->ren->locales()->trans('godmode_save_and_edit'),
					"class" => 'dimm',
				));
				$this->f->input(array(
					"type"  => 'submit',
					"name"  => 'save_and_add',
					"label" => $this->ren->locales()->trans('godmode_save_and_add'),
					"class" => 'dimm',
				));
			}

			return $this;
		}


		private function get_attr_options($attr, $def)
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

				} else throw new \System\Error\Format(sprintf('Invalid callback for options of attribute %s of model %s', $attr, $this->model));


			} else {
				foreach ($def['options'] as $oid=>$olabel) {
					$options[$oid] = $this->ren->locales()->trans($olabel);
				}
			}

			return $options;
		}


		public function f()
		{
			return $this->f;
		}


		public function passed()
		{
			return $this->f()->passed();
		}


		public function get_data()
		{
			return $this->f()->get_data();
		}


		/** Save data and object relations
		 * @return $this
		 */
		public function save()
		{
			$p = $this->f()->get_data();
			$rel_data = $this->separate_rel_data($p);

			$this->update_author();
			$this->object->update_attrs($p);
			$this->object->updated_at = new \Datetime();

			if (!$this->object->is_new()) {
				$this->object->created_at = new \Datetime();
			}

			$this->object->save();

			$this->save_relations($rel_data);
			return $this;
		}


		public function update_author()
		{
			if ($this->object->has_attr('author')) {
				$this->object->author = $this->f()->request()->user();
			}
		}


		/** Save predefined relations from post
		 * @param array $rel_data
		 */
		private function save_relations(array $rel_data)
		{
			/* Relation name => Relation edit method */
			foreach ($this->rels as $rel=>$expect) {
				$def  = \System\Model\Database::get_attr($this->model, $rel);
				$type = \System\Model\Database::get_attr_type($this->model, $rel);

				if ($type == \System\Model\Database::REL_HAS_MANY) {

					if ($expect === 'pick') {
						$ids = $this->get_ids_from_picker($rel_data, $rel);
					} elseif ($expect === 'manager') {
						$ids = $this->get_ids_from_rel_manager($rel_data, $rel);
					}

					$this->object->$rel = $ids;
				}
			}

			$this->object->save();
			return $this;
		}


		/** Separate relation data from other post data in place
		 * @param  array &$p Form data
		 * @return array Relation data
		 */
		private function separate_rel_data(&$p)
		{
			$attrs = \System\Model\Database::get_model_attrs($this->model);
			$rel_data = array();

			foreach ($attrs as $attr=>$def) {
				if ($def[0] == \System\Model\Database::REL_HAS_MANY) {
					if (isset($p[$attr])) {
						$rel_data[$attr] = $p[$attr];
						unset($p[$attr]);
					}
				}
			}

			return $rel_data;
		}


		/** Get list of IDs generated by relation picker
		 * @param  array  $rel_data Data from form
		 * @param  string $rel      Attribute name of the relation
		 * @return array
		 */
		private function get_ids_from_picker(array $rel_data, $rel)
		{
			if (isset($rel_data[$rel]) && is_array($rel_data[$rel])) {
				return array_map('intval', $rel_data[$rel]);
			} else return array();
		}


		/** Get list of IDs generated by relation manager
		 * @param  array  $rel_data Data from form
		 * @param  string $rel      Attribute name of the relation
		 * @return array
		 */
		private function get_ids_from_rel_manager(array $rel_data, $rel)
		{
			$ids = array();

			if (isset($rel_data[$rel]) && is_array($rel_data[$rel])) {
				$rel_def     = \System\Model\Database::get_attr($this->model, $rel);
				$rel_target  = \System\Model\Database::get_rel_bound_to($this->model, $rel);
				$attr_target = \System\Model\Database::get_belongs_to_id($rel_def['model'], $rel_target);

				if (isset($rel_data[$rel]['add'])) {
					// Create new objects
					foreach ($rel_data[$rel]['add'] as $data) {
						$empty = true;

						foreach ($data as $at=>$data_attr) {
							if (any($data_attr)) {
								$empty = false;
								break;
							}
						}

						if (!$empty) {
							$data[$attr_target] = $this->object->id;
							$obj = create($rel_def['model'], $data);
							$ids[] = $obj->id;
						}
					}

					unset($rel_data[$rel]['add']);
				}


				// Find objects referenced by ID skip if not found
				foreach ($rel_data[$rel] as $id=>$data) {
					if ($obj = find($rel_def['model'], $id)) {
						$obj->update_attrs($data);

						if ($obj->delete) {
							$obj->drop();
						} else {
							$obj->$attr_target = $this->object->id;
							$obj->save();
							$ids[] = $obj->id;
						}
					}
				}
			}

			return array_filter($ids);
		}
	}
}
