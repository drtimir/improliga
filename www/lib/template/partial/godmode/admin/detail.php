<?

Tag::div(array("class" => 'admin_detail'));

	echo section_heading(t('godmode_object_name', System\Loader::get_class_trans($model), $item->get_name()));

	Tag::ul(array("class" => 'attrs plain'));
		$parity = 'odd';

		foreach ($attrs as $attr) {
			$value = System\Template::to_html($item->$attr);
			if ($attr == System\Model\Database::get_id_col($model)) {
				$name = l('Id');
			} elseif (in_array($attr, array('created_at', 'updated_at'))) {
				$name = l($attr);
			} else {
				$name = System\Model\Attr::get_model_attr_name($model, $attr);
			}

			$parity = $parity == 'even' ? 'odd':'even';

			Tag::li(array(
				"class"   => array('prop', $parity),
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
