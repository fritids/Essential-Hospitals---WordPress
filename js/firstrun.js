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
                intro: "<span style='font-size:30px; line-height:36px;' >Welcome to the Member Network</span><br> Let us walk you through a few things to get started."
              },
              {
                element: '#run-news',
                intro: "Here is where you'll find any news you've subscibed to. You currently haven't subscribed to any news, but you can use the link in this section to register, or go to <em>My News</em> in the nav bar above"
              },
              {
                element: '#run-groups',
                intro: "This is where any private groups you're a member of will be stored. If you want, you can even request to create a group using the <em>Start a Private Group</em> button"
              },
              {
                element: '#run-discussion',
                intro: "Any discussions you have commented on will be listed here with the latest comment made. This way you can easily go back to a conversation you were having"
              },
              {
                element: '#run-comments',
                intro: "The latest conversations within AEH articles will be listed here and color coded based on their topics, similar to the top navigation"
              },
              {
                element: '#userProfile',
                intro: "This is your profile. You can easily edit it, view it, whatever you like by either clicking the <em>[edit profile]</em> link or clicking your profile image"
              },
              {
                element: '#run-webinars',
                intro: "If you are subscribed to any webinars then they will be listed here for easy access as well"
              },
              {
                element: '#run-connect',
                intro: "The heart of the AEH Member Network: people. Anyone you've befriended on the Member Network will be listed here for easy access"
              },
              {
                element: '#login',
                intro: "Clicking this will give you access to your Member Dashboard from wherever you are on the AEH site. Give it a click to see for yourself"
              },
              {
                element: '#membernetwork h1.title',
                intro: "That's it! We hope you enjoy the AEH Member Network!"
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
