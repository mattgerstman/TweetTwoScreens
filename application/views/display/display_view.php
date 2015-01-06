<div id="outside_container">

	<div id="tweetImg"></div>
	
	<div id="container"> 
	
	        <h1 class="tlt">
	       
	        	<ul class="texts" id="mainTexts">
		        	<?php
			        $i=0;
		        	 foreach ($tweets as $tweet):
		        	 $i++
		        	  ?>
		        	 	
					    <li id="tweet<?php echo $i;?>" tweet_id = "<? echo $tweet->id; ?>" username="<?php echo $tweet->username; ?>" img ="<?php if (isset($tweet->img)) {echo $tweet->img;} else {echo 'false';} ?>"><?php echo trim($tweet->message);?> 
						    		    
						    <img class="userImg" src="<?php echo str_replace('_normal', '_bigger', $tweet->image); ?>" />
						   </li>
	
					<?php endforeach ?>
	        	</ul>
	        	
	
	    </h1> 

	
	</div> 
	     <div id="userInfo"><div id="imgSpace" ></div><div id="username"></div></div>
  <div id="fullscreen"><img src = "<?php echo base_url('assets/images/fullscreen.png'); ?>"/> </div>
	<div id="question"><?php echo $question; ?></div>
</div>

   <script type="text/javascript"> 
	   var colors = ["#b695d7", "#fc65bd", "#ffcc00", "#99ff00","#93c1fa"];
	   var colorIndex = 0;
	   setInterval(function(){
		   $('#outside_container').animate({backgroundColor: colors[colorIndex]}, 5000);
		   console.log(colors[colorIndex]);
		   colorIndex++;
		   if (colorIndex >= colors.length)
		   	colorIndex = 0;
	   }, 20000);
	   
	   setInterval(function(){
		   $.post("question", {}, function(question){
		   	if (question != $("#question").html())
		   	{
			   $("#question").fadeOut(1000, function(){
			   	$("#question").html(question).fadeIn(1000);
			   })
		   	}

	   })}, 10000);
	   
	   $("#question").fitText(1, {maxFontSize:"40px"})
	   
	   var lastTweet = <?php echo $i; ?> + 1;
	   
	   var addTweets = function(tweets)
	   {
	   		$.each(tweets, function(i){
	   		var tweet = tweets[i]
	   		console.log(tweet);	 
	   		        tweet['image'] = tweet['image'].replace('_normal', '');  		
	   				   $("#mainTexts").append('<li id="tweet'+lastTweet+'" tweet_id = "'+tweet['id']+'" username ="'+tweet['username']+'" img="'+tweet['img']+'">'+tweet['message']+' <img class="userImg" src="'+tweet['image']+'" /></li>');
					   lastTweet++;

	   		});
	   };

	    var pt = 0; //pendingTweets
	    var pendingTweets = [];
  		var data = {'tweets' : ['316927951063117825']};
  		

  		var deadTweets = new Array();
  		
 		var usedTweet = function usedTweet(tweet)
 		{
 		
 			var tweetID = tweet.attr('id');
 			if (!($.inArray(tweetID, deadTweets)))
 			{
	 			deadTweets[tweetID] = 1;
 			}
 			else
 			{
 				deadTweets[tweetID]++;
	 			console.log("Reused a tweet "+deadTweets[tweetID]+" times");
 			}
 			
 			
 			tweet.remove();
 			pt ++;

 			if ((pt == 5) || ($("#mainTexts li").size() <5))
 			{
	 			$.post('display/getPendingTweets', {}, function(newTweets){
  					newTweets = $.parseJSON(newTweets);
		 			addTweets(newTweets);
		 			
		 			});
 			pt = 0;
 			}

 		}
 		
 		setInterval(function(){
	 		$.post('display/getPendingTweets', {}, function(newTweets){
  				newTweets = $.parseJSON(newTweets);
		 		addTweets(newTweets);
		 			
		 	});
 		}, 30000)
 	
		$('.tlt').textillate({
//		  	'minDisplayTime': 2000,
			'callback' : usedTweet,
			'in' : {
				'rand': true
			},
			'out' : {
				'rand': true
			}
		});
		
		
		var opacity = "0";
	
		var exitFullScreen = function() {
			opacity = "0";				
			$("#fullscreen").fadeTo(200, opacity);
		};
	
		$("#fullscreen").hover(function(){
			$("#fullscreen").fadeTo(200, "1.0");
		},
		function(){
			$("#fullscreen").fadeTo(200, opacity);
		}
		);
		
		var fullscreenState;
		
		document.addEventListener("fullscreenchange", function () {
	    	(document.fullscreen)? true : exitFullScreen();
	    
		}, false);
		
		document.addEventListener("mozfullscreenchange", function () {
		    (document.mozFullScreen)? true : exitFullScreen();
			    
		}, false);
		
		document.addEventListener("webkitfullscreenchange", function () {
		    fullscreenState = (document.webkitIsFullScreen)? "" : "not ";
		}, false);
		
		$("#fullscreen").click(function(){

		var e = document.getElementById("outside_container"); //document.documentElement;
		if (RunPrefixMethod(document, "FullScreen") || RunPrefixMethod(document, "IsFullScreen")) {
			RunPrefixMethod(document, "CancelFullScreen");
		}
		else {
			RunPrefixMethod(e, "RequestFullScreen");

			}
//		opacity = "1.0";
		$("#fullscreen").fadeTo(200, opacity);

		
		});
	

		var pfx = ["webkit", "moz", "ms", "o", ""];
	
		function RunPrefixMethod(obj, method) {
		
		var p = 0, m, t;
		while (p < pfx.length && !obj[m]) {
			m = method;
			if (pfx[p] == "") {
				m = m.substr(0,1).toLowerCase() + m.substr(1);
			}
			m = pfx[p] + m;
			t = typeof obj[m];
			if (t != "undefined") {
				pfx = [pfx[p]];
				return (t == "function" ? obj[m]() : obj[m]);
			}
			p++;
		}
		}

  
  </script> 
 
 <!--button onclick="$(document).fullScreen(true)">Full Screen</button-->
  </body> 