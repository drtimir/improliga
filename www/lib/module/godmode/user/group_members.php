<?

$this->req('id');

def($page, 0);
def($per_page, 20);
def($show_heading, true);

if ($group = find("\System\User\Group", $id)) {
	$users = $group->users->paginate($per_page, $page)->fetch();

	$this->partial('godmode/admin/list', array(
		"cols" => array(
			array('login', $locales->trans('godmode_user_login'), 'link'),
			array('get_name', $locales->trans('godmode_user_name'), 'function'),
			array('updated_at', $locales->trans('godmode_last_lgoin'), 'date'),
			array('created_at', $locales->trans('created_at'), 'date'),
			array(null, null, 'actions', array($locales->trans('godmode_edit') => 'edit', $locales->trans('godmode_delete') => 'delete')),
		),
		"items"     => $users,
		"heading"   => $show_heading ? sprintf(def($heading, $locales->trans('List users of group "%s"')), $group->name):null,
	));
} else throw new \System\Error\NotFound();
