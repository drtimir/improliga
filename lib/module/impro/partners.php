<?

$ren->partial('impro/static/partners', array("partners" => \Impro\Partner::visible()->fetch()));
