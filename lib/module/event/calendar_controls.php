<?

def($heading);
def($month_input);
def($year_start, intval(date("Y"))-2);
def($year_end,   intval(date("Y"))+1);
def($icon_size, 24);
def($url, System\Input::get('path'));

if ($month_input) {
	list($def_year, $def_month) = array_map('intval', explode('-', $month_input));
}

def($def_year, intval(date("Y")));
def($def_month, intval(date("m")));
def($def_day, intval(date("d")));
$years = array();

for ($i = $year_start; $i <= $year_end; $i++) {
	$years[' '.$i] = $i;
}

$def = array(
	"year"  => $def_year,
	"month" => $def_month,
	"day"   => $def_day,
);

$months = System\Locales::get('date:months');

$f = new System\Form(array(
	"method"  => 'get',
	"default" => $def,
	"class"   => def($form_class),
));

$f->input(array(
	"type"     => 'select',
	"name"     => 'month',
	"label"    => l('month'),
	"prefix"   => true,
	"required" => true,
	"options"  => array_flip(array_map('ucfirst', $months))
));

$f->input(array(
	"type"     => 'select',
	"name"     => 'year',
	"label"    => l('year'),
	"required" => true,
	"options"  => $years
));

$f->submit(l('show'));

$date = new DateTime();
if ($f->passed() || $month_input) {

	$p = $f->get_data();

	$propagate['month'] = def($p['month']);
	$propagate['year'] = def($p['year']);

	$date->setDate($p['year'], $p['month'], 1);

}

$nm = clone $date;
$nm->modify("+1 month");

$ny = clone $date;
$ny->modify("+1 year");

$pm = clone $date;
$pm->modify("-1 month");

$py = clone $date;
$py->modify("-1 year");

$pref = $f->get_prefix();

$junk = '&amp;'.$pref.'hidden_data={&quot;submited&quot;:1}&amp;'.$pref.'submited=true';

$this->template('impro/event/calendar_controls', array(
	"f" => &$f,
	"icon_size" => $icon_size,
	"heading"   => $heading,
	"link_prev_month"  => $url.'?'.$pref.'month='.intval($pm->format('m')).'&amp;'.$pref.'year='.$pm->format('Y').$junk,
	"link_prev_year"   => $url.'?'.$pref.'month='.intval($py->format('m')).'&amp;'.$pref.'year='.$py->format('Y').$junk,
	"link_next_month"  => $url.'?'.$pref.'month='.intval($nm->format('m')).'&amp;'.$pref.'year='.$nm->format('Y').$junk,
	"link_next_year"   => $url.'?'.$pref.'month='.intval($ny->format('m')).'&amp;'.$pref.'year='.$ny->format('Y').$junk,
));
