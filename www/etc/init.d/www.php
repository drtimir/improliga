<?

if (strpos($request->host, 'www') !== 0) {
	$redir = ($request->secure ? 'https':'http').'://www.'.$request->host.$request->path.($request->query ? '?'.$request->query:'');
	redirect_now($redir, \System\Http\Response::MOVED_PERMANENTLY);
}
