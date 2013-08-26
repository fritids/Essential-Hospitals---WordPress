$(document).ready(function(){
	queryURL = 'wp-content/themes/EssentialHospitals/partial/template-postquery.php';

	//Run It!
	$('nav#demo li a').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('nav#demo li a').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			
			//Hide elements
			$('#postBox #fader').fadeOut(400, function(){
				//Empty DIV then query posts
				$('#postBox #fader').empty();
				request(queryURL, dataFilter, '#postBox #fader');
			});
        }
	});
	
	//Post Query AJAX function
	function request(queryURL, dataFilter, targetDiv, callback){
	    $.ajax({
	        type: 'POST',
	        url: queryURL,
	        data: {ajaxFilter : dataFilter},
	        success: function(msg) {
	            $posts = $.parseHTML(msg);
	            $(targetDiv).append($posts);
	            wrapAndRender(targetDiv);
	        }
	    });
	    //Initiate callback function
		if (callback && typeof(callback) === "function") {  
	       	callback();  
		}  
	}
	
	//Wrap and Render posts callback function
	function wrapAndRender(wrapdiv){
	    postDiv = $(wrapdiv).children('div');	            
        for(var i = 0; i < postDiv.length; i+=2) {
            postDiv.slice(i, i+2)
            .wrapAll('<div class="item" />');
        }
        $(wrapdiv).fadeIn(400);
	}
});

