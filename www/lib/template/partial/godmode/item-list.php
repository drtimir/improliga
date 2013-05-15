<?

def($desc, '');
def($heading, '');
def($locals['heading']);
def($locals['name_format'], '{login}');

if (!defined("H_TEMPLATE_UNIVERSAL_ADMIN_LIST")) {
	define("H_TEMPLATE_UNIVERSAL_ADMIN_LIST", true);


	function admin_list_url(array $static, array $args, $action = null)
	{
		return $static['request']->url('god_'.implode('_', $static['link_god']).'_'.$action, $args);
	}


	function admin_list_format_value(array $col, $item, array $static)
	{
		def($col[2], '');
		def($col[3], '');
		def($col[4], '');

		if ($col[2] == "actions") {

			$str = '';
			foreach ($col[3] as $label=>$action) {
				$url = admin_list_url($static, array($item->id), $action);
				$str .= icon_for('godmode/actions/'.($action ? $action:'detail'), 16, $url, $label);
			}

			return $str;
		} elseif (strpos($col[2], "link") === 0) {
			$label_type = substr($col[2], 5);
			return '<a href="'.admin_list_url($static, array($item->id), 'detail').'">'.admin_list_format_value(array($col[0], $col[1], $label_type), $item, $static).'</a>';
		} elseif (strpos($col[2], "function") !== false) {
			return call_user_func(array($item, $col[0]));
		} elseif (strpos($col[2], "helper") !== false) {
			if (isset ($col[3][0]) && $col[3][0] == 'this') {
				$col[3][0] = $item;
			}
			return call_user_func_array($col[0], $col[3]);
		} elseif (strpos($col[2], "date") !== false) {
			return format_date($item->$col[0], 'human');
		} elseif (strpos($col[2], "number")) {
			$val = $col[3] ? eval("return ".$item->$col[0].$col[3].";"):$col[0];
			return $col[4] ? sprintf($col[4], $val):$val;
		} elseif (strpos($col[2], 'list') !== false) {
			if (isset($col[3])) {
				$val = array();

				if (is_array($col[3])) {
					foreach ($item->$col[0] as $v) {
						if (isset($col[3][$v])) {
							$helper[] = $col[3][$v];
						}
					}
				} else $val = $item->$col[0];
				$val = $helper;
			}

			return implode(',', $val);
		} else {

			if ($item->$col[0] instanceof Core\System\BasicModel) {

				$str = '';
				$obj = $item->$col[0];

				strpos($col[2], 'obj-link') !== false && $str .= '<a href="'.soprintf($col[3], $obj).'">';
				$str .= $obj->get_name($static['name_format']);
				strpos($col[2], 'obj-link') !== false && $str .= '</a>';
				return $str;

			} else {

				return is_bool($item->$col[0]) ?
					($item->$col[0] ? l('yes'):l('no')):
					($col[4] ? sprintf($col[4], $item->$col[0]):$item->$col[0]);
			}

		}
	}


	function admin_list_draw_table($locals)
	{
		$i=0;
		foreach ($locals as $key=>$val) {
			$$key = $val;
		}

		!isset($sortable) && $sortable = false;
		!isset($rels) && $rels = array();

		if (any($items)) {
			?>
			<table class="admin-table<?=$sortable ? ' sortable':null?>">
				<thead>
					<tr>
						<th><input type="checkbox" name="mass"></th>
						<?
						foreach ($cols as $key=>$col) {
							?><th class="col-<?=$key?>"><?=$col[1]?></th><?
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?
					foreach ($items as $item) {
						?>
							<tr class="<?=++$i%2 ? 'odd':'even'?> sort-item"<? if ($sortable) {?>id="sorty_<?=get_class($item)?>:<?=$item->id?>"<? } ?>>
								<td>
									<input type="checkbox" name="items[]" value="">
								</td>
								<?
								foreach ($cols as $col) {
									isset($col[2]) && $col[2] == 'actions' && $col[0] = 'actions';
									?>
									<td class="<?=$col[0]?>"><?=admin_list_format_value($col, $item, array("request" => $locals['request'], "module_id" => $module_id, "link_god" => $link_god, "name_format" => $name_format))?></td>
									<?
								}
								?>
							</tr>
							<?
							if (any($rels)) {
								foreach ($rels as $rel=>$attrs) {
									?>
									<tr>
										<td></td>
										<td colspan="<?=count($cols)-1?>">
											<?
												$attrs['items'] = $item->$rel->fetch();
												$attrs['module_id'] = $module_id;
												admin_list_draw_table($attrs);
											?>
										</td>
									</tr>
									<?
								}
							}
							?>
						<?
					}
					?>
				</tbody>
				<? if (isset($footer)) { ?>
					<tfoot>
						<tr>
							<?
							$c = count($cols) + 1;
							foreach ($footer as $f) {
								echo '<td>'.$f.'</td>';
								$c --;
							}

							for ($c; $c > 0; $c--) {
								echo '<td></td>';
							}
							?>
						</tr>
					</tfoot>
				<? } ?>
			</table><?
		}
	}


	function admin_list_draw_pagination($cur_page, $count, $per_page, array $class = array())
	{
		$out = array();
		$p = System\Input::get('path');

		if ($cur_page > 0) {
			$out[] = Tag::li(array("output" => false, "content" => Tag::a(array(
				"output"  => false,
				"href"    => $p.'?page='.($cur_page-1),
				"content" => '&laquo;',
				"title"   => l('godode_prev_page'),
			))));
		}

		for ($page = 1; $count > ($page - 1) * $per_page; $page++) {
			$fn = ($cur_page === $page - 1) ? 'span':'a';

			$out[] = Tag::li(array(
				"output"  => false,
				"class"   => array($cur_page === $page - 1 ? 'active':'inactive'),
				"content" => Tag::$fn(array(
					"output"  => false,
					"content" => $page,
					"href"    => $p.'?page='.($page - 1),
					"title"   => t('godmode_page', $page),
				))
			));
		}

		if ($cur_page + 1 < floor($count/$per_page)) {
			$out[] = Tag::li(array("output" => false, "content" => Tag::a(array(
				"output" => false,
				"href" => $p.'?page='.($cur_page+1),
				"content" => '&raquo;',
				"title"   => l('godode_next_page'),
			))));
		}

		Tag::ul(array(
			"content" => $out,
			"class"   => array_merge($class, array('paginator')),
		));
	}
}

?>
<div class="admin-list">
	<?

	echo section_heading($heading);
	$desc && Tag::p(array("content" => $desc));

	if (isset($count) && isset($per_page) && $count > $per_page) {
		admin_list_draw_pagination($page, $count, $per_page, array('top'));
	}

	$locals['request'] = $request;

	admin_list_draw_table($locals);

	if (empty($items)) {
		echo div("info", $heading, l('godmode_no_items'));
	}

	if (isset($count) && isset($per_page) && $count > $per_page) {
		admin_list_draw_pagination($page, $count, $per_page, array('bottom'));
	}
	?>
</div>
