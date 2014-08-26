<?

def($template, 'seo/team/list');

$this->partial($template, array(
	"teams" => get_all('\Impro\Team')->where(array(
		'published' => true
	))->fetch(),
));

