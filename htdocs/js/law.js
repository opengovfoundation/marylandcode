var disqus_identifier = window.location.pathname.replace(/\//g, '');

function disqus_config(){
	this.callbacks.onNewComment = [function(){closeSuggestions();}];
}

//Close title suggestion comment thread (opens law comment thread)
function closeSuggestions(){
	var identifier = window.location.href;
	var url = window.location.href;
				
	$('#suggest-arrow').html('&darr;');
	$('#disqus_thread').appendTo('article#law > section');
					
	$('#disqus-loc').val('law');
	
	loadDisqus($(this), identifier, url);
}

//Open title suggestion comment thread (closes law comment thread)
function openSuggestions(){
	var law = window.location.pathname.replace(/\//g, '');
	var identifier = 'suggestTitle_' + law;
	var url = window.location.href + '#!' + identifier;
					
	$('#suggest-arrow').html('(hide)');
	$('#disqus_thread').appendTo($('#suggest-title')); //append the HTML to the control parent
					
	$('#disqus-loc').val('title');
	
	loadDisqus($(this), identifier, url);
}


//Reload Disqus
function loadDisqus(source, identifier, url, title) {

   	if (window.DISQUS){
   		//if Disqus exists, call it's reset method with new parameters
   		DISQUS.reset({
      		reload: true,
      		config: function () {
      			this.page.identifier = identifier;
      			this.page.url = url;
      		}
   		});

	} else {

		//insert a wrapper in HTML after the relevant "show comments" link
		$('<div id="disqus_thread"></div>').insertAfter('article#law > section');
		disqus_identifier = identifier; //set the identifier argument
		disqus_url = url; //set the permalink argument

		//append the Disqus embed script to HTML
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
		$('head').appendChild(dsq);
	}
};

$(document).ready(function(){
	$('#suggest-title').click(function(){
		if($('#disqus-loc').val() == 'law'){
			openSuggestions();
		}else{
			closeSuggestions();
		}
	});
});