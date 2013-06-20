pwf.register('window_form', function()
{
	var
		self = this,
		ready = false,
		class_iframe_helper = function()
		{
			var
				self  = this,
				ready = false,
				win   = null,
				form  = null,
				container = null,
				if_instance = null,
				if_name = '';


			this.bind = function(w, f)
			{
				win  = w;
				form = f;

				if_name = 'gm_iframe_helper_' + win.attr('id') + '_' + form.attr('id');
				create_iframe();
				target_form();
			};


			this.ready = function()
			{
				return ready;
			};


			this.get_form = function()
			{
				return form;
			};


			this.get_iframe_name = function()
			{
				return if_name;
			};


			this.get_container = function()
			{
				if (container === null) {
					if ((container = $('#window_form_container')).length === 0) {
						container = $('<div id="window_form_container"></div>');
						$('body').append(container);
					}
				}

				return container;
			};


			var create_iframe = function()
			{
				if ((if_instance = self.get_container().find(self.get_iframe_name())).length <= 0) {
					if_instance = $('<iframe name="'+self.get_iframe_name()+'" id="'+self.get_iframe_name()+'"></iframe>');
					if_instance.bind('load', {"win":win, "form":form, "helper":self, "iframe":if_instance}, iframe_callback);
					self.get_container().append(if_instance);
				}
			};


			var target_form = function()
			{
				form.attr('target', if_name);
			};


			var iframe_callback = function(e)
			{
				var body = $(this).contents().find('body');

				if (body.length === 1 && body.html().length > 0) {
					win.set_content(body.html());
				}
			};


			this.destroy = function()
			{
				if_instance.remove();
				delete if_instance;
			};
		};

	this.init = function()
	{
		return ready = true;
	};


	this.ready = function()
	{
		return ready;
	};


	this.bind = function(win)
	{
		var content = win.get_content_ref();
		var forms = content.find('form');

		for (var i = 0; i<forms.length; i++) {
			var form = $(forms[i]);

			if (!form.hasClass('gm_nobind')) {
				var helper = new class_iframe_helper();
				helper.bind(win, form);
			}
		}

		return this;
	};
});
