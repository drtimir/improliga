<?

$group_ids = array(2);
$groups = get_all('\System\User\Group')->where(array('id_system_user_group IN ('.implode(',', $group_ids).')'))->fetch();

$this->partial('impro/support/list', array(
	"groups" => $groups,
));
