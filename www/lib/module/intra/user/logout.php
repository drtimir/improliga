<?

System\User::logout();

message('success', l('godmode_user_logout_success'));
redirect('/');
