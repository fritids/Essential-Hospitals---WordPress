$(document).ready(function(){
	queryURL = 'wp-content/themes/EssentialHospitals/partial/template-postquery.php';
	
	//Initial Masonry and Slider
	postDiv = $('#fader .items').children('div.post');	            
    for(var i = 0; i < postDiv.length; i+=2) {
        postDiv.slice(i, i+2)
        .wrapAll('<div class="item" />');
    }
    $('#fader .items > .item').each(function(){
	    $(this).prepend('<div class="fixed-box stamp"></div>'); 
	});
	
	$masonrycont = $('#fader .items .item');
	$masonrycont.masonry({
	  //columnWidth: 200,
	  itemSelector: '.post',
	  stamp:		'.stamp',
	});
	var msnry = $masonrycont.data('masonry');
        
	$('#fader').scrollable({
		circular: 	 false,
		next:		'#nextbtn',
		prev:		'#prevbtn',
		speed:		400,
		onBeforeSeek: function() {
			var currSlide = api.getIndex();
			$('.items > div.post').each(function() {
				$(this).removeClass('active');
			});
		},
		onSeek: function() {
			var currSlide = api.getIndex();
			currSlide = currSlide + 1;
			$('.items > div.post:eq(' + currSlide + ')').addClass('active');
		}
	}).navigator();
	var api = $('#fader').data('scrollable');
	
	
	//Run on-click
	$('div.filters div').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('div.filters div').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			//Hide elements
			$('#postBox #fader').fadeOut(400, function(){
				$('#postBox #fader .items').css('left','0px');
				//Empty DIV then query posts
				$('#postBox #fader .item').remove();
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
	            var postInject = $(targetDiv).children('.items');
	            $(postInject).append($posts);
	            wrapAndRender(postInject);
	        }
	    });
	    //Initiate callback function
		if (callback && typeof(callback) === "function") {  
	       	callback();  
		}  
	}
	
	//Wrap and Render posts callback function
	function wrapAndRender(wrapdiv){
	    postDiv = $(wrapdiv).children('div.post');	            
        for(var i = 0; i < postDiv.length; i+=2) {
            postDiv.slice(i, i+2)
            .wrapAll('<div class="item" />');
        }
        $('#fader .items > .item').each(function(){
		    $(this).prepend('<div class="fixed-box"></div>'); 
		});
        masonryAndSlides();
        $('#fader').fadeIn(400);
	}
	
	//Masonry Function
	function masonryAndSlides(wrapdiv){
		//Masonry
		$masonrycont = $('#fader .items .item');
		$masonrycont.masonry({
		  //columnWidth: 200,
		  itemSelector: '.post',
		});
		var msnry = $masonrycont.data('masonry');
		
		
		
	}
});

