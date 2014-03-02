function myGetElementsByClassName(selector) {
	if (document.getElementsByClassName) {
		return document.getElementsByClassName(selector);
	}

	var returnList = new Array();
	var nodes = document.getElementsByTagName('div');
	var max = nodes.length;
	for ( var i = 0; i < max; i++) {
		if (nodes[i].className == selector) {
			returnList[returnList.length] = nodes[i];
		}
	}
	return returnList;
}

var rssReader = {
	containers : null,

	// initialization function
	init : function(selector) {
		containers = myGetElementsByClassName(selector);
		for (i = 0; i < containers.length; i++) {
			// getting necessary variables
			var rssUrl = $('#rss_url').attr('value');
			var num = $('#rss_nb_news').attr('value');
			var id = $('#post_results').attr('id');

			// creating temp scripts which will help us to transform XML (RSS)
			// to JSON
			var url = encodeURIComponent(rssUrl);
			var googUrl = 'https://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num='
					+ num
					+ '&q='
					+ url
					+ '&callback=rssReader.parse&context='
					+ id;

			var script = document.createElement('script');
			script.setAttribute('type', 'text/javascript');
			script.setAttribute('charset', 'utf-8');
			script.setAttribute('src', googUrl);
			containers[i].appendChild(script);
		}
	},

	// parsing of results by google
	parse : function(context, data) {
		var container = document.getElementById(context);
		container.innerHTML = '';

		// creating list of elements
		var mainList = document.createElement('ul');

		// also creating its childs (subitems)
		var entries = data.feed.entries;
		for ( var i = 0; i < entries.length; i++) {
			var listItem = document.createElement('li');
			var title = entries[i].title;
			if (title.length >= '55') {
				var title = title.substr(0,55)+'...';
			}
			var contentSnippet = entries[i].contentSnippet;
			var contentSnippetText = document.createTextNode(contentSnippet);

			var link = document.createElement('a');
			link.setAttribute('href', entries[i].link);
			link.setAttribute('target', '_blank');
			var text = document.createTextNode(title);
			link.appendChild(text);

			// add link to list item
			listItem.appendChild(link);

			var desc = document.createElement('p');
			desc.appendChild(contentSnippetText);

			// add description to list item
			listItem.appendChild(desc);

			// adding list item to main list
			mainList.appendChild(listItem);
		}
		container.appendChild(mainList);
	}
};

window.onload = function() {
	rssReader.init('post_results');
};
