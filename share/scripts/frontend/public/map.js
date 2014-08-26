pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.setup({
		'map':[
			{
				'name':'home',
				'anchor':'/{section:string:no}',
				'cname':'ui.public.structure.home',
				'structure':[
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'header',
							'parallax':true,
							'structure':['ui.public.home.']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'about',
							'link':'o-improlize',
							'structure':['ui.public.about.']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'shows',
							'link':'predstaveni',
							'parallax':true,
							'structure':['ui.public.shows.']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'teams',
							'link':'tymy',
							'structure':['ui.public.teams.']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'workshops',
							'link':'workshopy',
							'parallax':true,
							'structure':['ui.public.workshops.']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'media',
							'link':'media-o-improlize',
							'structure':['ui.public.media.']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'contact',
							'link':'kontakty',
							'parallax':true,
							'structure':['ui.public.contact.']
						}
					}
				]
			},

			{
				'name':'show_detail',
				'anchor':'/predstaveni/{item:seoname}',
				'structure':[
					'ui.public.home.header',
					'ui.public.event.'
				]
			},

			{
				'name':'team_detail',
				'anchor':'/tymy/{item:seoname}',
				'structure':['ui.public.team.']
			}
		]
	});
});
