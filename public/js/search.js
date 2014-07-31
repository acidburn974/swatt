var Search = {

	searchInput: $('#search-input'),

	init: function() {
		this.searchInput.on('change', function() {
			this.load();
		});
	},

	load: function() {
	},
}

//Search.init();