pwf.register('godmode', function() {

	this.components = {};
	var
		ready = false,
		trans = null,
		component_callbacks = [];


	this.init = function init()
	{
		init_trans();
		return ready = true;
	};


	var init_trans = function()
	{
		if (typeof pwf_trans === 'undefined') {
			trans = {};
			v("Failed to load pwf translations");
		} else trans = pwf_trans;
	};


	this.is_ready = function()
	{
		return ready;
	};


	this.register = function(name, object)
	{
		this.components[name] = new object();

		if (this.components[name].init() === true) {
			this.run_component_callbacks();
		} else {
			v("Godmode component "+name+" failed to init!");
		}
	};


	this.trans = function(key)
	{
		return typeof trans[key] === 'undefined' ? key:trans[key];
	};


	this.when_components_are_ready = function(components, lambda, args)
	{
		if (this.are_components_ready(components)) {
			lambda(args);
		} else component_callbacks.push([components, lambda, args]);
	};


	this.run_component_callbacks = function()
	{
		for (var i = 0; i < component_callbacks.length; i++) {
			var cb = component_callbacks[i];

			if (cb !== null && this.are_components_ready(cb[0])) {
				cb[1](typeof cb[2] == 'undefined' ? null:cb[2]);
				component_callbacks[i] = null;
			}
		}
	};


	this.are_components_ready = function(components)
	{
		var ready = false;

		for (var comp_i = 0 in components) {
			if (!(ready = this.is_component_ready(components[comp_i]))) break;
		}

		return ready;
	};


	this.is_component_ready = function(component)
	{
		return typeof this.components[component] != 'undefined' && this.components[component].is_ready();
	};

});

