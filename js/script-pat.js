$(document).ready(function(){
	//URL for template
	var templateDir = 'http://mlinson.staging.wpengine.com/wp-content/themes/EssentialHospitals';
	var queryURL = templateDir+'/partial/template-postquery.php';
	var querytype = $('#pagefilter').attr('data-query');
	var pageQueryURL = templateDir+'/partial/template-postquery'+querytype+'.php';
	var tagQueryURL = templateDir+'/partial/template-tagquery.php';
	var archiveQueryURL = templateDir+'/partial/template-archivequery.php';
	var seriesQueryURL = templateDir+'/partial/template-seriesquery.php';
	var searchQuery = templateDir+'/membernetwork/searchquery.php';
	var userQuery = templateDir+'/membernetwork/userquery.php';
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

	var authorlayout1 = new Array();
		authorlayout1[0] = 'wide';
		authorlayout1[1] = 'short';
		authorlayout1[2] = 'tall';
		authorlayout1[3] = 'wide';
		authorlayout1[4] = 'tall';
		authorlayout1[5] = 'wide';
		authorlayout1[6] = 'short';
	var authorlayoutarray = new Array();
		authorlayoutarray[0] = authorlayout1;
	//Page filter
	//Initial Masonry and Slider
	postDiv = $('#fader .items').children('div.post');
	if($('body.home').size()){
		wrapNum = 5;
	}else if($('body.tag').size() || $('body.tax-series').size() || $('body.page-template-templatestemplate-authorfeed-php').size()){
		wrapNum = 7;
	}else if($('body.author.archive').size()){
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
    		}else if($('body.author.archive').size()){
				var randomItem = authorlayoutarray[Math.floor(Math.random()*authorlayoutarray.length)];
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
		touch: 		false,
		onBeforeSeek: function() {
			var currSlide = api.getIndex();
			$('.items > div.item').each(function() {
				$(this).removeClass('active');
			});
		},
		onSeek: function() {
			var currSlide = api.getIndex();
			currSlide = currSlide + 1;
			$('.items > div.item:eq(' + currSlide + ')').addClass('active');
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
				$('#loader-gif').addClass('active');
				$('#postBox #fader .item').remove();
				request(queryURL, dataFilter, '#postBox #fader');

			},300);
        }
	});
	//General archive
	$('body.archive div.filters div').click(function(){
		if(!$(this).hasClass('active')){
        	//Set variables and classes
			$('div.filters div').removeClass('active');
			$(this).addClass('active');
			dataFilter = $(this).attr('data-filter');
			archiveFilter = $(this).attr('data-archive');
			taxFilter = $(this).attr('data-tax');
			//Hide elements
			$('#postBox .post').addClass('close');
			api.seekTo(0,1);
			//Empty DIV then query posts
			setTimeout(function(){
				$('#loader-gif').addClass('active');
				$('#postBox #fader .item').remove();
				requestArchive(archiveQueryURL, dataFilter, archiveFilter, '#postBox #fader', taxFilter);

			},300);
        }
	});
	//Tag archive
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
				$('#loader-gif').addClass('active');
				$('#postBox #fader .item').remove();
				requestArchive(tagQueryURL, dataFilter, archiveFilter, '#postBox #fader');

			},300);
        }
	});
	//Series archive
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
				$('#loader-gif').addClass('active');
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
				$('#loader-gif').addClass('active');
				$('#postBox #fader .item').remove();
				request(pageQueryURL, dataFilter, '#postBox #fader');

			},300);

			if($(this).parent().hasClass('mobile-active')){
				$(this).parent().slideToggle(200).removeClass('mobile-active');
			}
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
				$('#loader-gif').addClass('active');
				$('#postBox #fader .item').remove();
				requestDual(pageQueryURL, dataFilter, timeFilter, '#postBox #fader');

			},300);

			if($(this).parent().hasClass('mobile-active')){
				$(this).parent().slideToggle(200).removeClass('mobile-active');
			}
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
				$('#loader-gif').addClass('active');
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
	            $('#loader-gif').removeClass('active');
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
	            $('#loader-gif').removeClass('active');
	        }
	    });
	    //Initiate callback function
		if (callback && typeof(callback) === "function") {
	       	callback();
		}
	}
	//Archive
	function requestArchive(queryURL, dataFilter, archiveFilter, targetDiv, taxFilter, callback){
	    $.ajax({
	        type: 'POST',
	        url: queryURL,
	        data: {ajaxFilter : dataFilter, archiveFilter : archiveFilter, taxFilter : taxFilter},
	        success: function(msg) {
	            $posts = $.parseHTML(msg);
	            var postInject = $(targetDiv).children('.items');
	            $(postInject).append($posts);
	            wrapAndRender(postInject, wrapNum);
	            $('#loader-gif').removeClass('active');
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
		colTruncate();
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
	setTimeout(function(){
		heightArray = [];
		$('.groupcol , .heightcol, #instituteCenters .center').each(function(){
		   $elemheight = $(this).height();
		   heightArray.push($elemheight);
		});
		$newheight = Math.max.apply(Math, heightArray);
		$('.groupcol, .heightcol, #instituteCenters .center').height($newheight);
		$('#membercontent .graybarleft,#membercontent .graybarright,#content .graybarleft,#content .graybarright').height($newheight);
	}, 500);
	//$('#memberdash').height($(document).height());
// ----- Member Network
	//Bio Limit
	$('<span id="memBio"><em>bio cannot be more than 140 characters. Character count: <span id="limiter">0</span>/140</em></span>').insertAfter('#wpmem_reg textarea#description');
	//$('#wpmem_reg #memBio #limiter').text($('#wpmem_reg textarea#description').val().length);
	$('#wpmem_reg textarea#description').keyup(function(){
		$elem = $(this);
		$val = $(this).val();
		if($val.length > 140){
			$val = $val.substring(0, 140);
			$elem.val($val);
		}
		$('#wpmem_reg #memBio #limiter').text($val.length);
	});
	//Autofill Members
	$.xhrPool = [];
	$.xhrPool.abortAll = function() {
	    $(this).each(function(idx, jqXHR) {
	        jqXHR.abort();
	    });
	    $(this).each(function(idx, jqXHR) {
	        var index = $.inArray(jqXHR, $.xhrPool);
	        if (index > -1) {
	            $.xhrPool.splice(index, 1);
	        }
	    });
	};

	$.ajaxSetup({
	    beforeSend: function(jqXHR) {
	        $.xhrPool.push(jqXHR);
	    },
	    complete: function(jqXHR) {
	        var index = $.inArray(jqXHR, $.xhrPool);
	        if (index > -1) {
	            $.xhrPool.splice(index, 1);
	        }
	    }
	});
	$input = $('#newgroup input[name="membersearch"]');
	$input.keyup(function(){
		$inputVal = $input.val();
		if($inputVal.length > 2){
			$.xhrPool.abortAll();
			$('#userloader').addClass('active');
			userRequest($inputVal);
		}else{
			$('#autp_fillcont').empty();
		}
	});
	//Set Member array and Members container
	$memArray = [];
	$memContainer = $('#members-added');
	//Add a Member
	$('#autp_fillcont div.autp_fillentry a').live('click',function(){
		$id = $(this).attr('data-ID');
		$memArray.push($id);
		$memArray = jQuery.unique($memArray);
		$('input[name="group_mem"]').val($memArray);
		$('input[name="membersearch"]').val('');
		$('#autp_fillcont').empty();
		$(this).parent().clone().appendTo('#members-added');
		if($memContainer.has('.autp_fillentry')){
			$('h2#memtitle').show();
		}else{
			$('h2#memtitle').hide();
		}
		$('.groupcol').css('height','auto');
	});
	//Remove a Member
	$('#members-added div.autp_fillentry a').live('click',function(){
		$memID = $(this).attr('data-id');
		$memArray = $.grep($memArray, function(value) {
		  return value != $memID;
		});
		$('input[name="group_mem"]').val($memArray);
		$(this).parent().remove();
		if($memContainer.has('.autp_fillentry')){
			$('h2#memtitle').show();
		}else{
			$('h2#memtitle').hide();
		}
	});
	//User AJAX request
	function userRequest($inputVal){
		$.ajax({
	        type: 'POST',
	        url: userQuery,
	        data: {userQuery: $inputVal},
	        success: function(msg) {
	            $('#autp_fillcont').html(msg);
	            $('#userloader').removeClass('active');
	        }
	    });
	}
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
	$('#disc-content.orig .reply.sendto').click(function(){
		$('body').scrollTo('textarea#comment');
	});
	$('#showmore').click(function(){
		$('#addNews').slideToggle(200, function(){
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
	});
	$('<span id="memEmail"><em>use your business email to have full access to Member Network features</em></span>').insertAfter('#wpmem_reg input#user_email');
	$('#siteWrap #memNetwork').click(function(){
		$('#siteWrap').toggleClass('memnetwork');
		$('#memberdash').toggleClass('memnetwork');
		setTimeout(function() {
	      $('#siteWrap.memnetwork').one('click',function(){
			$('#siteWrap').removeClass('memnetwork');
			$('#memberdash').removeClass('memnetwork');
		});
		}, 500);
	});
	$('#siteWrap #search img').click(function(){
		$(this).stop().toggleClass('active');
		$('#siteWrap #searchWrap').stop().toggleClass('active');
		$('#siteWrap #searchWrap input[type="text"]').attr('placeholder','Search').focus();
	});
	$('#siteWrap #loginButton').click(function(){
		$(this).stop().toggleClass('active');
		if($('#siteWrap #search.active').length > 0){
			$('#siteWrap #search').toggleClass('active');
			$('#siteWrap #searchWrap').stop().slideToggle(300);
		}
		$('#siteWrap #loginBoxPanel').stop().slideToggle(300);
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
	$('#siteWrap #searchWrap input[type="text"]').keyup(function(){
		getSearch = $(this).val();
		if($(this).val().length >=2){
			$.ajax({
		        type: 'POST',
		        url: searchQuery,
		        data: {getSearch : getSearch},
		        success: function(msg) {
		            $('#siteWrap #searchWrap #searchQuery').html(msg);
		        }
		    });
	    }else{
		    $('#siteWrap #searchWrap #searchQuery').empty();
	    }
	});
	$('#uploadAvatar').insertAfter('#profile-mod');
	//Tag tile title check
	if($('body.archive').length != 0){
		$('.item .post.short').each(function(){
			//$removeme = $(this).find('p');
			$titlelen = $(this).find('.item-header h2').text().length;
			/*if($titlelen >= 50){
				$removeme.remove();
			}*/
		});
	}
	if($('#contentPrimary.action').length != 0 || $('#contentPrimary.quality').length != 0){
		$('.item .post.long').each(function(){
			//$removeme = $(this).find('p');
			$titlelen = $(this).find('.item-header h2').text().length;
			/*if($titlelen >= 50){
				$removeme.remove();
			}*/
		});
	}
	$('.post.short').each(function(){
		//$removeme = $(this).find('p');
		$titlelen = $(this).find('.item-header h2').text().length;
		/*if($titlelen >= 50){
			$removeme.remove();
		}*/
	});
	//Breadcrumb last selector
	$('#breadcrumbs ul li:visible:last').addClass('last');
	//Get right most masonry tiles
	$('.item .post').each(function(){
	});
	//Responsive
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		function resizeMasonry(){
			$curPanel = api.getIndex();
			$msn = $('#postBox #fader');
			$pHeight = 0;
			$('#postBox #fader .items .item:eq('+$curPanel+') .post').each(function(){
				$pHeight = $pHeight + $(this).height();
			});
			$msn.height($pHeight);
			$pHeight = 0;
		}
		if($('#postBox #fader').length > 0){
			resizeMasonry();
		}
		if($('#institutePostBox').length > 0){
			$('#institutePostBox').masonry();
		}
		$('#mobile-slide').hammer({
			prevent_default: true,
			drag: false,
			transform: false,
			hold: false,
			tap_double: false}).on("tap", function(event) {
	        $('#mobileHeader,body').addClass('active');
	        //event.stopPropagation();
	    });
		$('#mobileHeader').hammer({
			swipe_velocity:0.3}).on('swiperight',function(event){
			$('#mobileHeader,body').removeClass('active');
		});
		$('.people_box').hammer().on('touch',function(event){
			$ind = $('.p_hover:visible').parent().index();
			if($(this).children('.p_hover').is(':visible')){
				$('#banner').find('.p_hover:not(:eq('+$ind+'))').fadeOut(200);
			}else{
				$('.p_hover').fadeOut(200);
				$(this).children('.p_hover').fadeIn(200);
			}
		});
		$('.scrollable').hammer({
			swipe_velocity:0.3}).on('swipeleft',function(event){
			$('#nextbtn').click();
			resizeMasonry();
		});
		$('.scrollable').hammer({
			swipe_velocity:0.3}).on('swiperight',function(event){
			$('#prevbtn').click();
			resizeMasonry();
		});
		$('#page-filters').hammer({
			prevent_default: true,
			drag: false,
			transform: false,
			hold: false,
			tap_double: false}).on('tap',function(event){
			$(this).next('ul#pagefilter').slideToggle(200).addClass('mobile-active');
		});

	}
	//Short Column truncate - excerpt
	function colTruncate(){
		$('#contentWrap:not(.institute, .webinar) .post.long.tall').each(function(i){
			$content = $(this).children('.item-content').children('p').text();
			$contentcontainer = $(this).children('.item-content').children('p');
			$contentlen = $content.length;

			if($contentlen > 100){
				$content = $content.replace(/^(.{100}[^\s]*).*/, "$1");
				$contentcontainer.text($content+' [...]');
			}
		});
	}
	$('#contentWrap:not(.institute, .webinar) .post.long.tall').each(function(i){
		$content = $(this).children('.item-content').children('p').text();
		$contentcontainer = $(this).children('.item-content').children('p');
		$contentlen = $content.length;

		if($contentlen > 100){
			$content = $content.replace(/^(.{100}[^\s]*).*/, "$1");
			$contentcontainer.text($content+' [...]');
		}
	});
});
jQuery.fn.scrollTo = function( target, options, callback ){
  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
  var settings = $.extend({
    scrollTarget  : target,
    offsetTop     : 50,
    duration      : 500,
    easing        : 'swing'
  }, options);
  return this.each(function(){
    var scrollPane = $(this);
    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
      if (typeof callback == 'function') { callback.call(this); }
    });
  });
}