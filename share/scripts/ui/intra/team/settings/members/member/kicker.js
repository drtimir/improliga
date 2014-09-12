pwf.rc('ui.intra.team.settings.members.member.kicker', {
	'parents':['ui.question'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Member',
			'attrs':['roles'],
			'on_yes':function() {
				var
					item = this.get('item'),
					url  = '/api/team/' + item.get('team').get('id') + '/member/' + item.get('id') + '/kick';

				v(this);

				this.get_el().trigger('loading_start');

				pwf.comm.get(url, {}, function(ctrl) {
					return function(e, res) {
						ctrl.get_el().trigger('loading_stop');
						v(e, res);
					};
				}(this));
			}
		}
	}
});
