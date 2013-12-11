$(document).ready(function(){
	//URL for template
	var templateDir = 'http://mlinson.staging.wpengine.com/wp-content/themes/EssentialHospitals';

	var queryURL = templateDir+'/partial/template-postquery.php';
	var querytype = $('#pagefilter').attr('data-query');
	var pageQueryURL = templateDir+'/partial/template-postquery'+querytype+'.php';
	var tagQueryURL = templateDir+'/partial/template-tagquery.php';
	var seriesQueryURL = templateDir+'/partial/template-seriesquery.php';
	var searchQuery = templateDir+'/membernetwork/searchquery.php';

	//Home masonry layouts
	var layout1 = new Array();
	    layout1[0] = 'wide';
	    layout1[1] = 'tall';
	    layout1[2] = 'tall';
	    layout1[3] = 'tall';
	    layout1[4] = 'wide';
	var layout2 = new Array();
	    layout2[0] = 'wide';
	    layout2[1] = 'tall';
	    layout2[2] = 'wide';
	    layout2[3] = 'wide';
	    layout2[4] = 'wide';
	var layout3 = new Array();
	    layout3[0] = 'tall';
	    layout3[1] = 'tall';
	    layout3[2] = 'tall';
	    layout3[3] = 'wide';
	    layout3[4] = 'wide';
	var layout4 = new Array();
	    layout4[0] = 'tall';
	    layout4[1] = 'wide';
	    layout4[2] = 'wide';
	    layout4[3] = 'wide';
	    layout4[4] = 'wide';

	var layoutarray = new Array();
	    layoutarray[0] = layout1;
	    layoutarray[1] = layout2;
	    layoutarray[2] = layout3;
	    layoutarray[3] = layout4;

	//Interior masonry layouts
	var intlayout1 = new Array();
	    intlayout1[0] = 'tall';
	    intlayout1[1] = 'tall';
	    intlayout1[2] = 'tall';
	    intlayout1[3] = 'wide';
	    intlayout1[4] = 'tall';
	var intlayout2 = new Array();
	    intlayout2[0] = 'tall';
	    intlayout2[1] = 'wide';
	    intlayout2[2] = 'tall';
	    intlayout2[3] = 'tall';
	    intlayout2[4] = 'tall';
	var intlayout3 = new Array();
	    intlayout3[0] = 'wide';
	    intlayout3[1] = 'tall';
	    intlayout3[2] = 'tall';
	    intlayout3[3] = 'tall';
	    intlayout3[4] = 'tall';
	var intlayout4 = new Array();
	    intlayout4[0] = 'tall';
	    intlayout4[1] = 'tall';
	    intlayout4[2] = 'tall';
	    intlayout4[3] = 'tall';
	    intlayout4[4] = 'wide';

	var intlayoutarray = new Array();
	    intlayoutarray[0] = intlayout1;
	    intlayoutarray[1] = intlayout2;
	    intlayoutarray[2] = intlayout3;
	    intlayoutarray[3] = intlayout4;

	//Tag masonry layouts
	var taglayout1 = new Array();
		taglayout1[0] = 'wide';
		taglayout1[1] = 'tall';
		taglayout1[2] = 'short';
		taglayout1[3] = 'tall';
		taglayout1[4] = 'tall';
		taglayout1[5] = 'tall';
		taglayout1[6] = 'short';

	var taglayoutarray = new Array();
		taglayoutarray[0] = taglayout1;

	//Page filter


	//Initial Masonry and Slider
	postDiv = $('#fader .items').children('div.post');

	if($('body.home').size()){
		wrapNum = 5;
	}else if($('body.tag').size() || $('body.tax-series').size() || $('body.page-template-templatestemplate-authorfeed-php').size()){
		wrapNum = 7;
	}else{
		wrapNum = 5;
	}

    for(var i = 0; i < postDiv.length; i+=wrapNum) {
        postDiv.slice(i, i+wrapNum)
        .wrapAll('<div class="item" />');
    }
    $('.item').each(function(i){

    		if($('body.home').size()){
	    		var randomItem = layoutarray[Math.floor(Math.random()*layoutarray.length)];
    		}else if($('body.tag').size() || $('body.tax-series').size() || $('body.page-template-templatestemplate-authorfeed-php').size()){
    			var randomItem = taglayoutarray[Math.floor(Math.random()*taglayoutarray.length)];
    		}else{
	    		var randomItem = intlayoutarray[Math.floor(Math.random()*intlayoutarray.length)];
    		}

		    $(this).children('.post').each(function(i){
		        $(this).addClass(randomItem[i]);
		    });
		});
    $('#fader .items > .item').each(function(){
	    $(this).prepend('<div class="fixed-box stamp"></div>');
	});

	if($('body.tag').size() || $('body.tax-series').size() || $('body.page-template-templatestemplate-authorfeed-php').size()){
		$colWidth = 280;
	}else{
		$colWidth = 280;
	}
	$masonrycont = $('#fader .items .item');
	$masonrycont.masonry({
	  columnWidth   : $colWidth,
	  itemSelector  : '.post',
	  stamp			: '.stamp',
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
	$('body.home div.filters div').click(function(){
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
	//Archive
	$('body.tag div.filters div').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('div.filters div').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			archiveFilter = $(this).attr('data-archive');
			//Hide elements
			$('#postBox .post').addClass('close');
			api.seekTo(0,1);
			//Empty DIV then query posts
			setTimeout(function(){
				$('#postBox #fader .item').remove();
				requestArchive(tagQueryURL, dataFilter, archiveFilter, '#postBox #fader');
			},300);
        }
	});
	$('body.tax-series div.filters div').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('div.filters div').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			archiveFilter = $(this).attr('data-archive');
			//Hide elements
			$('#postBox .post').addClass('close');
			api.seekTo(0,1);
			//Empty DIV then query posts
			setTimeout(function(){
				$('#postBox #fader .item').remove();
				requestArchive(seriesQueryURL, dataFilter, archiveFilter, '#postBox #fader');
			},300);
        }
	});
	//Action/Quality/Education/Institute
	$('ul#pagefilter:not(.webinar) li').click(function(){
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
	//Webinars (dual filter)
	$('ul#pagefilter.webinar li').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('ul#pagefilter.webinar li').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			timeFilter = $('div.timeButton.active').attr('data-time');
			//Hide elements
			$('#postBox .post').addClass('close');
			api.seekTo(0,1);
			//Empty DIV then query posts
			setTimeout(function(){
				$('#postBox #fader .item').remove();
				requestDual(pageQueryURL, dataFilter, timeFilter, '#postBox #fader');
			},300);
        }
	});
	$('div.timeButton').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('div.timeButton').removeClass('active');
			$(this).addClass('active');
			dataFilter = $('ul#pagefilter.webinar li.active').attr('data-filter');
			timeFilter = $(this).attr('data-time');
			//Hide elements
			$('#postBox .post').addClass('close');
			api.seekTo(0,1);
			//Empty DIV then query posts
			setTimeout(function(){
				$('#postBox #fader .item').remove();
				requestDual(pageQueryURL, dataFilter, timeFilter, '#postBox #fader');
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
	            wrapAndRender(postInject, 5);
	        }
	    });
	    //Initiate callback function
		if (callback && typeof(callback) === "function") {
	       	callback();
		}
	}

	//Dual Post Query AJAX function
	function requestDual(queryURL, dataFilter, timeFilter, targetDiv, callback){
	    $.ajax({
	        type: 'POST',
	        url: queryURL,
	        data: {ajaxFilter : dataFilter, timeFilter : timeFilter},
	        success: function(msg) {
	            $posts = $.parseHTML(msg);
	            var postInject = $(targetDiv).children('.items');
	            $(postInject).append($posts);
	            wrapAndRender(postInject, 6);
	        }
	    });
	    //Initiate callback function
		if (callback && typeof(callback) === "function") {
	       	callback();
		}
	}

	//Archive
	function requestArchive(queryURL, dataFilter, archiveFilter, targetDiv, callback){
	    $.ajax({
	        type: 'POST',
	        url: queryURL,
	        data: {ajaxFilter : dataFilter, archiveFilter : archiveFilter},
	        success: function(msg) {
	            $posts = $.parseHTML(msg);
	            var postInject = $(targetDiv).children('.items');
	            $(postInject).append($posts);
	            wrapAndRender(postInject, wrapNum);
	        }
	    });
	    //Initiate callback function
		if (callback && typeof(callback) === "function") {
	       	callback();
		}
	}

	//Wrap and Render posts callback function
	function wrapAndRender(wrapdiv, wrapnum){
	    postDiv = $(wrapdiv).children('div.post');
        for(var i = 0; i < postDiv.length; i+=wrapnum) {
            postDiv.slice(i, i+wrapnum)
            .wrapAll('<div class="item" />');
        }
        $('.item').each(function(i){
        	if($('body.home').size()){
	    		var randomItem = layoutarray[Math.floor(Math.random()*layoutarray.length)];
    		}else if($('body.tag').size() || $('body.page-template-templatestemplate-authorfeed-php').size()){
    			var randomItem = taglayoutarray[Math.floor(Math.random()*taglayoutarray.length)];
    		}else{
	    		var randomItem = intlayoutarray[Math.floor(Math.random()*intlayoutarray.length)];
    		}
		    $(this).children('.post').each(function(i){
		        $(this).addClass(randomItem[i]);
		    });
		});
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
		  columnWidth: $colWidth,
		  itemSelector: '.post',
		  stamp:		'.stamp',
		});
		var msnry = $masonrycont.data('masonry');
	}
	//Institute Masonry
	$masonrycont = $('#institutePostBox');
	$masonrycont.masonry({
	  columnWidth: 280,
	  itemSelector: '.post',
	  stamp:		'.stamp',
	});
	var msnry = $masonrycont.data('masonry');

	//Add New discussion
	$('button#newdisc').click(function(){
		$('#newDiscussion').toggleClass('active').slideToggle(300);
	});

	//Height Balancing
	heightArray = [];
	$('.groupcol , .heightcol, #instituteCenters .center').each(function(){
	   $elemheight = $(this).height();
	   heightArray.push($elemheight);
	});
	$newheight = Math.max.apply(Math, heightArray);
	$('.groupcol, .heightcol, #instituteCenters .center').height($newheight);
	$('#membercontent .graybarleft,#membercontent .graybarright,#content .graybarleft,#content .graybarright').height($newheight);



	//$('#memberdash').height($(document).height());

	//Member Network
	$('#my-profile-wpm #theuser,#my-profile-wpm hr').remove();
	$('#my-profile-wpm ul li').each(function(i){
		$(this).addClass('profileedit-'+i);
	});

	$('#memberLogin #wpmem_login div:contains("New User?")').remove();


	$('#newsFeed .post').each(function(){
		if($(this).index() % 2){
			$(this).addClass('even');
		}
	});

	//Search/Membernetwork
	$('#memNetwork').click(function(){
		$('#siteWrap').toggleClass('memnetwork');
		$('#memberdash').toggleClass('memnetwork');
		setTimeout(function() {
	      $('#siteWrap.memnetwork').one('click',function(){
			$('#siteWrap').removeClass('memnetwork');
			$('#memberdash').removeClass('memnetwork');
		});
		}, 500);
	});

	$('#search img').click(function(){
		$(this).stop().toggleClass('active');
		$('#searchWrap').stop().toggleClass('active');
		$('#searchWrap input[type="text"]').attr('placeholder','Search').focus();
	});
	$('#loginButton').click(function(){
		$(this).stop().toggleClass('active');
		if($('#search.active').length > 0){
			$('#search').toggleClass('active');
			$('#searchWrap').stop().slideToggle(300);
		}
		$('#loginBoxPanel').stop().slideToggle(300);
	});

	$('input[name="user_avatar_edit_submit"]').attr('value','upload');
	$('a.edit-avatar').click(function(){
		$('#uploadAvatar').toggle();
		heightArray = [];
		$('.groupcol').each(function(){
			$(this).css('min-height',$(this).height()).height('auto');
		   $elemheight = $(this).height();
		   heightArray.push($elemheight);
		});
		$newheight = Math.max.apply(Math, heightArray);
		$('.groupcol').height($newheight);
		$('#membercontent .graybarleft,#membercontent .graybarright').height($newheight);
	});
	$('a:contains("TOS")').text('Terms of Use');



	//Search AJAX
	$('#searchWrap input[type="text"]').keyup(function(){
		getSearch = $(this).val();
		if($(this).val().length >=2){
			$.ajax({
		        type: 'POST',
		        url: searchQuery,
		        data: {getSearch : getSearch},
		        success: function(msg) {
		            $('#searchQuery').html(msg);
		        }
		    });
	    }else{
		    $('#searchQuery').empty();
	    }
	});
	$('#uploadAvatar').insertAfter('#profile-mod');

	//Tag tile title check
	if($('body.archive').length != 0){
		$('.item .post.short').each(function(){
			$removeme = $(this).find('p');
			$titlelen = $(this).find('.item-header h2').text().length;
			if($titlelen >= 50){
				$removeme.remove();
			}
		});
	}
	if($('#contentPrimary.action').length != 0 || $('#contentPrimary.quality').length != 0){
		$('.item .post.long').each(function(){
			$removeme = $(this).find('p');
			$titlelen = $(this).find('.item-header h2').text().length;
			if($titlelen >= 50){
				$removeme.remove();
			}
		});
	}
	$('.post.short').each(function(){
		$removeme = $(this).find('p');
		$titlelen = $(this).find('.item-header h2').text().length;
		if($titlelen >= 50){
			$removeme.remove();
		}
	});

	//Breadcrumb last selector
	$('#breadcrumbs ul li:visible:last').addClass('last');

	//Get right most masonry tiles
	$('.item .post').each(function(){

	});
});

