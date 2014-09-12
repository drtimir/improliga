pwf.rc('ui.intra.team.settings.members.member.kicker', {
	'parents':['ui.question'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Member',
			'attrs':['roles'],
			'on_yes':function() {
				v(this.get('item'));
			}
		}
	}
});
