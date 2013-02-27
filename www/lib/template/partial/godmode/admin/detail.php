<?

Tag::div(array("class" => 'admin_detail'));

	echo section_heading(t('godmode_object_name', System\Model\Attr::get_model_model_name($model), $item->get_name()));

	Tag::ul(array("class" => 'attrs'));

		foreach ($attrs as $attr) {
			$value = System\Template::to_html($item->$attr);

			if ($attr == System\Model\Database::get_id_col($model)) {
				$name = l('Id');
			} elseif (in_array($attr, array('created_at', 'updated_at'))) {
				$name = l($attr);
			} else {
				$name = System\Model\Attr::get_model_attr_name($model, $attr);
			}

			Tag::li(array(
				"class"   => 'prop',
				"content" => array(
					Tag::span(array(
						"class"   => 'name',
						"content" => $name.': ',
						"output"  => false,
					)),
					Tag::span(array(
						"class"   => 'value',
						"content" => $value,
						"output"  => false,
					)),
				)
			));
		}

	Tag::close('ul');
Tag::close('div');
