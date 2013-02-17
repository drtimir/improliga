<?

try {
	$generator = System\Output::introduce();
} catch(Exception $e) { $generator = 'pwf-unknown'; }


echo NL;
echo 'Error has occurred'.NL;
echo '-------------------------'.NL;


$exp  = $desc->get_explanation();
$back = $desc->get_backtrace();


foreach ($exp as $ex) {
	echo TAB."- ".$ex;
}

echo NL;
echo NL;


foreach ($back as $b) {
	$skip = isset($b['object']) && $b['object'] === $desc;

	if (isset($b['file'])) {
		echo substr($b['file'], strlen(ROOT));

		if (isset($b['line'])) {
			echo ':'.$b['line'];
		}

		echo ' ';
	}


	if (!$skip && isset($b['function'])) {
		echo 'in function ';

		if (isset($b['class'])) {
			echo $b['class'].'::';
		}

		echo $b['function'].'()';

		if (isset($b['args']) && any($b['args'])) {
			echo NL;

			foreach ($b['args'] as $key=>$arg) {
				echo TAB.($key).':'.var_export($arg, true);
			}
		}
	}

	echo NL;
	echo NL;
}