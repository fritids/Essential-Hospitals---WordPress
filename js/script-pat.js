$(document).ready(function(){
	queryURL = 'wp-content/themes/EssentialHospitals/partial/template-postquery.php';
	querytype = $('#pagefilter').attr('data-query');
	pageQueryURL = 'wp-content/themes/EssentialHospitals/partial/template-postquery'+querytype+'.php';
	
	//Header
	$('#search').hover(function(){
		$('#loginBox').css('display','none');
		if($('#searchBox').is(':visible')){
			$('#searchBox').css('display','none');
		}else{
			$('#searchBox').css('display','inline');
		}
	});
	$('#login').hover(function(){
		$('#searchBox').css('display','none');
		if($('#loginBox').is(':visible')){
			$('#loginBox').css('display','none');
		}else{
			$('#loginBox').css('display','inline');
		}
	});
	
	//Page filter
	$('#pagefilter li').each(function(){
		filterclass = $(this).text();
		filterclass = filterclass.replace('-','').replace('&','').replace('+','').replace(/\s+/g, '-').toLowerCase();
		$(this).attr('data-filter',filterclass);
	});
	
	//Initial Masonry and Slider
	postDiv = $('#fader .items').children('div.post');	            
    for(var i = 0; i < postDiv.length; i+=5) {
        postDiv.slice(i, i+5)
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
		speed:		300,
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
	//Home
	$('div.filters div').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('div.filters div').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			//Hide elements
			$('#postBox .post').addClass('close');
			api.seekTo(0,1);
			//Empty DIV then query posts
			setTimeout(function(){
				$('#postBox #fader .item').remove();
				request(queryURL, dataFilter, '#postBox #fader');
			},300);
        }
	});
	//Action/Quality/Education/Institute
	$('ul#pagefilter li').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('ul#pagefilter li').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			//Hide elements
			$('#postBox .post').addClass('close');
			api.seekTo(0,1);
			//Empty DIV then query posts
			setTimeout(function(){
				$('#postBox #fader .item').remove();
				request(pageQueryURL, dataFilter, '#postBox #fader');
			},300);
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
        for(var i = 0; i < postDiv.length; i+=5) {
            postDiv.slice(i, i+5)
            .wrapAll('<div class="item" />');
        }
        $('#fader .items > .item').each(function(){
		    $(this).prepend('<div class="fixed-box stamp"></div>'); 
		});
        masonryAndSlides();
        $('#postBox .post.close').removeClass('close');
	}
	
	//Masonry Function
	function masonryAndSlides(wrapdiv){
		//Masonry
		$masonrycont = $('#fader .items .item');
		$masonrycont.masonry({
		  //columnWidth: 200,
		  itemSelector: '.post',
		  stamp:		'.stamp',
		});
		var msnry = $masonrycont.data('masonry');
	}
});

