jQuery(document).ready(function($){

	//----- All Connections
		//# per page
		$('#contact-forms select#perpage').change(function(){
			$offset = $(this).val();
			$search = $('#queryholder').attr('data-search');
			$sortby = $('#queryholder').attr('data-sortby');
			$('#contactRender').fadeOut(200,function(){
				$(this).empty();
			});
			$('#loader-gif').addClass('active');
			 $.ajax({
		        type: 'POST',
		        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactquery.php',
		        data: {coffset : $offset, csearch : $search, csort : $sortby, caction : 'perpage'},
		        success: function(msg) {
		        	$('#infinitescroll').remove();
		            $('#contactRender').html(msg).fadeIn(200);
		            $('#loader-gif').removeClass('active');
		            $('#queryholder').attr('data-search',$search).attr('data-offset',$offset).attr('data-sortby',$sortby).attr('data-page','0');
		        }
		    });
		});
		//sort by
		$('th.sortby-btn > div').click(function(){
			$sortby = $(this).attr('data-sortby');
			$offset = $('#queryholder').attr('data-offset');
			$search = $('#queryholder').attr('data-search');
			$('#contactRender').fadeOut(200,function(){
				$(this).empty();
			});
			$('#loader-gif').addClass('active');
			 $.ajax({
		        type: 'POST',
		        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactquery.php',
		        data: {coffset : $offset, csearch : $search, csort : $sortby, caction : 'sortby'},
		        success: function(msg) {
		        	$('#infinitescroll').remove();
		            $('#contactRender').html(msg).fadeIn(200);
		            $('#loader-gif').removeClass('active');
		            $('#queryholder').attr('data-search',$search).attr('data-offset',$offset).attr('data-sortby',$sortby).attr('data-page','0');
		        }
		    });
		});
		//search by
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
		$input = $('#contact-table .profilesearch input#profile-search');
		$input.bindWithDelay("keyup", function(){
			$search = $(this).val();
			$offset = $('#queryholder').attr('data-sortby');
			$sortby = $('#queryholder').attr('data-sortby');
			$len = $search.length;
			if($len > 3){
				$('#contactRender').fadeOut(200,function(){
					$(this).empty();
				});
				$('#loader-gif').addClass('active');
				 $.ajax({
			        type: 'POST',
			        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactquery.php',
			        data: {csearch : $search, caction : 'search'},
			        success: function(msg) {
			        	$('#infinitescroll').remove();
			            $('#contactRender').html(msg).fadeIn(200);
			            $('#loader-gif').removeClass('active');
			            $('#queryholder').attr('data-search',$search).attr('data-offset',$offset).attr('data-sortby','').attr('data-page','0');
			        }
			    });
		    }
		}, 200);

		//Infinite Scroll
		function isScrolledIntoView(elem){
		    var docViewTop = $(window).scrollTop();
		    var docViewBottom = docViewTop + $(window).height();

		    var elemTop = $(elem).offset().top;
		    var elemBottom = elemTop + $(elem).height();

		    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
		}
		function infinitescroll(){
			scrollcheck = isScrolledIntoView('#infinitescroll');
			if(scrollcheck){
				//Unbind the scroll event
				$(window).unbind('scroll');
				$offset = $('#queryholder').attr('data-offset');
				$search = $('#queryholder').attr('data-search');
				$sortby = $('#queryholder').attr('data-sortby');
				$page = $('#queryholder').attr('data-page');
					$page = parseInt($page);
					$page++;
				$.ajax({
			        type: 'POST',
			        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactquery.php',
			        data: {coffset : $offset, cpage : $page, csort : $sortby, caction : 'paginate'},
			        success: function(msg) {
			        	console.log(msg);
			            $(msg).insertBefore('#contactRender #infinitescroll');
			            $('#queryholder').attr('data-search',$search).attr('data-offset',$offset).attr('data-sortby',$sortby).attr('data-page',$page);
			            //Rebind the scroll event
			            setTimeout(function(){
			            	$(window).bind('scroll',function(){infinitescroll();});
			            }, 200);

					}
				});
			}
		}
			//Check if trigger is in view
			$(window).bind('scroll',function(){infinitescroll();});

		//Reset Filters
		$('.styled-reset #reset-btn').click(function(){
			$sortby = '';
			$offset = '';
			$search = '';
			$('#contactRender').fadeOut(200,function(){
				$(this).empty();
			});
			$('#loader-gif').addClass('active');
			 $.ajax({
		        type: 'POST',
		        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactquery.php',
		        data: {coffset : $offset, csearch : $search, csort : $sortby, caction : 'reset'},
		        success: function(msg) {
		        	$('#infinitescroll').remove();
		            $('#contactRender').html(msg).fadeIn(200);
		            $('#loader-gif').removeClass('active');
		            $('#queryholder').attr('data-search',$search).attr('data-offset',$offset).attr('data-sortby',$sortby).attr('data-page',0);
		        }
		    });
		});



	//----- Add Contact
	$('#contactRender .contact-add').click(function(){
		$uid = $(this).attr('data-uid');
		$curid = $(this).attr('data-curid');
		$.ajax({
	        type: 'POST',
	        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactprocquery.php',
	        data: {curid : $curid , uid : $uid , action : 'add'},
	        success: function(msg) {
				console.log(msg);
	        }
	    });
	});

	//----- Approve Contact
	$('.pending-contact .approve').click(function(){
		$uid = $(this).attr('data-uid');
		$curid = $(this).attr('data-curid');
		$.ajax({
	        type: 'POST',
	        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactprocquery.php',
	        data: {curid : $curid , uid : $uid , action : 'approve'},
	        success: function(msg) {
				console.log(msg);
	        }
	    });
	});

	//----- Remove Contact


	//----- Deny Contact
	$('.pending-contact .deny').click(function(){
		$uid = $(this).attr('data-uid');
		$curid = $(this).attr('data-curid');
		$.ajax({
	        type: 'POST',
	        url: '/wp-content/themes/EssentialHospitals/membernetwork/contactprocquery.php',
	        data: {curid : $curid , uid : $uid , action : 'deny'},
	        success: function(msg) {
				console.log(msg);
	        }
	    });
	});
});

//Bind with delay - for keyup on AJAX input fields
(function($) {
$.fn.bindWithDelay = function( type, data, fn, timeout, throttle ) {
    if ( $.isFunction( data ) ) {
        throttle = timeout;
        timeout = fn;
        fn = data;
        data = undefined;
    }
    // Allow delayed function to be removed with fn in unbind function
    fn.guid = fn.guid || ($.guid && $.guid++);
    // Bind each separately so that each element has its own delay
    return this.each(function() {
        var wait = null;
        function cb() {
            var e = $.extend(true, { }, arguments[0]);
            var ctx = this;
            var throttler = function() {
                wait = null;
                fn.apply(ctx, [e]);
            };
            if (!throttle) { clearTimeout(wait); wait = null; }
            if (!wait) { wait = setTimeout(throttler, timeout); }
        }
        cb.guid = fn.guid;
        $(this).bind(type, data, cb);
    });
};
})(jQuery);