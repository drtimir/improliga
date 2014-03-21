pwf.register('templater', function()
{
	var templates = null;


	this.is_ready = function()
	{
		return pwf.mi(['comm']);
	};


	this.load_all = function(next)
	{
		if (templates === null) {
			pwf.comm.get('/api/templates/', {}, function(ctrl, next) {
				return function(err, response) {
					if (!err && response) {
						templates = response.templates;
					}

					for (var key in templates) {
						ich.addTemplate(key, templates[key]);
					}

					next(err, ctrl);
				};
			}(this, next));
		} else {
			next(null, this);
		}
	};


	this.get = function(name)
	{
		return typeof templates[name] == 'undefined' ? null:templates[name];
	};
});
