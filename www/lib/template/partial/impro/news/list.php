<div class="news">
	<?
		echo section_heading(l('impro_news'));

		if (any($news)) {

			Tag::ul();

			foreach ($news as $item) {
				Tag::li(array(
					"content" => array(
						heading($item->title),
						Tag::div(array(
							"class"   => 'text',
							"content" => $item->text,
							"output"  => false,
						))
					)
				));
			}

			Tag::close('ul');

		} else Tag::p(array("content" => l('impro_no_news')));
	?>
</div>
