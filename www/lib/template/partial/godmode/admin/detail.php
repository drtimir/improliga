<?

Tag::div(array("class" => 'admin_detail'));

	echo $renderer->heading($locales->trans('godmode_object_name', ucfirst($locales->trans_class_name($model)), $item->get_name()));

	Tag::ul(array("class" => 'attrs plain'));
		$parity = 'odd';

		foreach ($attrs as $attr) {
			if ($item->$attr instanceof \System\Database\Query) {
				$value = to_html($ren, $item->$attr->fetch());
			} else {
				$value = to_html($ren, $item->$attr);
			}

			if ($attr == System\Model\Database::get_id_col($model)) {
				$name = $locales->trans('Id');
			} elseif (in_array($attr, array('created_at', 'updated_at'))) {
				$name = $locales->trans($attr);
			} else {
				$name = $locales->trans_model_attr_name($model, $attr);
			}

			$parity = $parity == 'even' ? 'odd':'even';

			Tag::li(array(
				"class"   => array('prop', $parity),
				"content" => array(
					div('name', $name.': '),
					div('value', $value),
				)
			));
		}

	Tag::close('ul');
Tag::close('div');
