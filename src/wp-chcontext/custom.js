//File for custom UI translations and custom data providers.

// ===================== CUSTOM TRANSLATIONS

var PSNC = PSNC || {};
PSNC.chsearch = PSNC.chsearch || {};

//Put your custom translations below, e.g.:
/*
PSNC.chsearch.fr = {
	"seeMore" : "voir plus",
	"noResults" : "Pas de résultats",
	"found" : "résultats",
	"poweredBy" : "fourni par",
	"titleLabel" : "Titre",
	"authorLabel" : "Auteur"
}; 
*/


// ===================== CUSTOM DATA PROVIDERS

// Below an example of custom data provider code. To use it you must uncomment the code below 
// and provide 'FBCtest' value in the field "Name of the JS function for custom data provider:" 
// in the widget confguration.

/*
var FBCtest = function(dataHandler) {
		// uri to api endpoint
		var serviceUrl = 'http://beta.fbc.pionier.net.pl/';
		var searchUrl = serviceUrl + 'index/select';
		var resourceUrl = serviceUrl + 'details/';
		var thumbnailUrl = serviceUrl + 'thumbnails/';
		var searchResultUrl = serviceUrl + 'search/query?q=';

		var dataProvider = {
			link: serviceUrl,
			img: "data:image/png;base64,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",
			name: "FBCtest"
		};

		var mapData = function(rawData) {
			var result = {};
			result.resultsLink = searchResultUrl + encodeURIComponent(rawData.responseHeader.params.q);
			result.numFound = rawData.response.numFound;
			result.dataProvider = dataProvider;
			result.results = jQuery.map(rawData.response.docs, function(doc, i) {
				var title = doc.dc_title;
				if (title !== undefined && title instanceof Array) {
					title = title[0];
				}
				var author = doc.dc_creator;
				if (author !== undefined && author instanceof Array) {
					author = author[0];
				}
				return {
					link: resourceUrl + doc.id,
					imgLink: thumbnailUrl + doc.id,
					title: title,
					author: author};
			});
			dataHandler(result);
		};

		this.search = function(searchString, maxNumberOfElements) {
			jQuery.ajax({
				url: searchUrl + '?q=' + encodeURIComponent(searchString) + '&rows=' + maxNumberOfElements + '&fl=dc_title%2Cdcterms_alternative%2Cdc_creator%2Cdc_contributor%2Cid&wt=json&json.wrf=?',
				timeout: 2000,
				dataType: 'json',
				data: {},
				// error: ajaxErrorHandler,
				success: mapData
			});
		};
	};
*/