pwf.register('godmode', function() {

	this.components = {};
	var
		ready = false,
		messages = null,
		component_callbacks = [];


	this.init = function init()
	{
		init_trans();
		return ready;
	};


	var init_trans = function()
	{
		if (typeof pwf_trans === 'undefined') {
			messages = {};
			v("Failed to load pwf translations");
			ready = false;
		} else {
			messages = pwf_trans['messages'];
			ready = true;
		}
	};


	this.is_ready = function()
	{
		return ready;
	};


	this.trans = function(key)
	{
		return typeof messages[key] === 'undefined' ? key:messages[key];
	};
});

