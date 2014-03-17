<?

echo $ren->heading('Podmínky použití');
echo p('Tyto podmínky se vztahují k používání služeb intranetu Improligy');


echo ul('index', array(
	li($ren->link('#zakladni-ustanoveni', 'Základní ustanovení')),
	li($ren->link('#autorska-prava', 'Autorská práva')),
	li($ren->link('#ochrana-osobnich-udaju', 'Ochrana osobních údajů')),
));


echo $ren->heading('Základní ustanovení');

echo $ren->heading_static('Provozovatel');
echo p('Provozovatelem je vlastník této domény podle záznamů whois.');

echo $ren->heading_static('Intranet');
echo p('Intranet je webová služba provozovaná na této doméně.');

echo $ren->heading_static('Autorská práva', $ren->heading_level - 1);

echo ol('', array(
	li(sprintf(
		'Samotná aplikace je vystavena pod licencí GNU/GPL. Její zdrojové kódy jsou dostupné na %s',
		$ren->link('http://github/just-paja/improliga', 'GitHubu')
	)),
	li('Odpovědnost za veškerý obsah nahraný na intranet nese uživatel.'),
));

echo $ren->heading_static('Ochrana osobních údajů');

echo ol('', array(
	li('Žádné vaše údaje nikdy nebudou předány třetím stranám.'),
	li('Kontaktní údaje jsou sdíleny mezi uživateli intranetu, pouze pokud k tomu uživatel dá souhlas.'),
	li('Na intranetu nejsou sbírány žádné údaje, které by vedly k jednoznačnému identifikování uživatele.'),
	li('Na intranetu je nastaven standardní sběr informací pomocí Google Analytics pouze za účelem sbírání statistik.'),
));
