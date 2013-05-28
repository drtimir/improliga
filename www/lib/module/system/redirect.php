<?

$this->req('url');
def($code, 307);

$flow->redirect($url, $code);
