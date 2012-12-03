<?

System\User::logout();

message('success', _('Byl jste úspěšně odhlášen'));
redirect('/god');
