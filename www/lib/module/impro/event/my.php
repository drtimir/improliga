<?

def($template, 'impro/event/list_mine');
def($conds, array());


$f = $ren->form(array(
	"method"  => 'get',
	"class"   => 'event_filter',
	"heading" => $locales->trans('intra_events_my'),
	"default" => array(
		'archive'      => true,
		'planned'      => true,
		'visible'      => false,
		'invisible'    => true,
		'published'    => false,
		'unpublished'  => true,
	)
));

$f->input_checkbox('archive', $locales->trans('intra_archive'));
$f->input_checkbox('planned', $locales->trans('intra_planned'));
$f->input_checkbox('visible', $locales->trans('intra_visible'));
$f->input_checkbox('invisible', $locales->trans('intra_invisible'));
$f->input_checkbox('published',  $locales->trans('intra_published'));
$f->input_checkbox('unpublished',  $locales->trans('intra_unpublished'));

$f->submit('Filtrovat');
$f->out($this);

$p = $f->get_data();


$conds['id_author'] = $request->user()->id;


if (empty($p['visible']) || empty($p['invisible'])) {
	if (any($p['visible']))   $conds['visible'] = true;
	if (any($p['invisible'])) $conds['visible'] = false;
}

if (empty($p['published']) || empty($p['unpublished'])) {
	if (any($p['published']))   $conds['published'] = true;
	if (any($p['unpublished'])) $conds['published'] = false;
}

if (empty($p['archive'])) {
	$conds[] = 'start >= NOW()';
}

if (empty($p['planned'])) {
	$conds[] = 'start <= NOW()';
}


$query = get_all("\Impro\Event")->where($conds)->sort_by('start')->paginate($per_page, $page);
$items = $query->fetch();

$this->partial($template, array(
	"events"       => $items,
));
