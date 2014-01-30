function firstRun(currentUser){
	queryURL = templateDir+'/membernetwork/firstrun.php';
	  $.ajax({
        type: 'POST',
        url: queryURL,
        data: {currentUser : currentUser},
        success: function(msg) {
        }
    });
	var intro = introJs();
          intro.setOptions({
            steps: [
              {
                element: '#membernetwork h1.title',
                intro: "<span style='font-size:30px; line-height:36px;' >Welcome to the Member Network</span><br>Take a quick walkthrough of your new account’s features (click “next”)"
              },
              {
                element: '#membernetwork',
                intro: "<span style='font-size:30px; line-height:36px;' >This is your dashboard</span><br>Use the black navigation bar to access all the features of your account. Build your profile, view and customize your content of interest, post questions and discussions, quickly access your collaborative program groups and webinars, and make connections with fellow members. When you’re signed in, the \"My Dashboard\" button in the upper right corner will be visible on any part of the website you visit. One click gives you access to all of this information."
              },
              {
                element: '#run-news',
                intro: "<span style='font-size:30px; line-height:36px;' >Your custom content feed</span><br>You can easily customize your dashboard to show the latest headlines from your interest areas (“Headlines selected for you”). Just below your customized feed, “All Recent” displays the most recent articles published by America’s Essential Hospitals. Content can include critical updates, learning opportunities, feature articles, and more."
              },
              {
                element: '#run-disccomm',
                intro: "<span style='font-size:30px; line-height:36px;' >Community discussions & content comments</span><br>After you’ve contributed to or started a community discussion, you can revisit the conversation right from your dashboard. The most recent message posted to each discussion where you participated show here. Just below, see what people are talking about today on the whole website. The \"recent comments on content\" area contains the latest comments readers have posted on sitewide articles and media."
              },
              {
                element: '#userProfile',
                intro: "<span style='font-size:30px; line-height:36px;' >View and edit your profile</span><br>This is a preview of your profile. After this tour, click on the image or the \"edit profile\" button to add or change your photo, edit details, and publish a bio."
              },
              {
                element: '#membernetwork',
                intro: "America's Essential Hospitals is here to support and bring together people dedicated to higher quality, more accessible health care. Make good use of your new community!"
              },

            ]
          });

          intro.start();
          $('.introjs-skipbutton').on('click',function(){
	         $('body > .introjs-tooltip').remove();
          });
		  $('.introjs-tooltip').clone().prependTo('body');
		  $( "body > .introjs-tooltip .introjs-prevbutton" ).one( "click", function() {
	      		console.log('hey');
			  $('.introjs-helperLayer .introjs-tooltip .introjs-prevbutton').click();
			});
			$( "body > .introjs-tooltip .introjs-nextbutton" ).one( "click", function() {
				console.log('hey');
			  $('.introjs-helperLayer .introjs-tooltip .introjs-nextbutton').click();
			});
			$( "body > .introjs-tooltip .introjs-skipbutton" ).one( "click", function() {
				console.log('hey');
			  $('.introjs-helperLayer .introjs-tooltip .introjs-skipbutton').click();
			});
		  intro.onbeforechange(function(){
		  	$( "body > .introjs-tooltip").remove();
		  });
          intro.onchange(function(){
	          	setTimeout(function(){
	          		$('.introjs-tooltip').clone().prependTo('body');
	          		if($('body > .introjs-tooltip .introjs-skipbutton').text() == 'Done'){
				  		$('body > .introjs-tooltip .introjs-skipbutton').addClass('done');
				  		$('body > .introjs-tooltip .introjs-prevbutton, body > .introjs-tooltip .introjs-nextbutton').remove();
				  	};
	          		$( "body > .introjs-tooltip .introjs-prevbutton" ).one( "click", function() {
		          		console.log('hey');
					  $('.introjs-helperLayer .introjs-tooltip .introjs-prevbutton').click();
					});
					$( "body > .introjs-tooltip .introjs-nextbutton" ).one( "click", function() {
						console.log('hey');
					  $('.introjs-helperLayer .introjs-tooltip .introjs-nextbutton').click();
					});
					$( "body > .introjs-tooltip .introjs-skipbutton" ).one( "click", function() {
						console.log('hey');
					  $('.introjs-helperLayer .introjs-tooltip .introjs-skipbutton').click();
					});
	          	}, 500);

          	});
}
