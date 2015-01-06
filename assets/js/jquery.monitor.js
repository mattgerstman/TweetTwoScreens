jQuery.fn.extend({

	approve: function() {
	
	if ($("#pending_tweets .tweet").size() != 0)
	{
		var tweet_id = $(this).attr('key');	
		$.post("monitor/approveTweet", {"tweet_id": tweet_id});


		var tweet = $(this).parent();
		var tweetClone = tweet.clone();
		var next = tweet.next();

		tweet.fadeTo(500, 0.00, function(){
			$(this).slideUp(250, function(){
				$(this).remove();		
			});
		});
		
		setTimeout(function(){
			tweetClone.hide().appendTo('#approved_tweets').fadeIn(500);				
		}, 500);
	}

		
	if (($("#pending_tweets .tweet").size() < 10) && approve)
	{
		console.log($("#pending_tweets .tweet").size());
		getNewTweets();
	}
		
	return $(this);
	},
	
	display: function() {
	
	if ($("#approved_tweets .tweet").size() != 0)
	{
		var tweet_id = $(this).attr('key');	
		$.post("monitor/pendTweet", {"tweet_id": tweet_id});


		var tweet = $(this).parent();
		var tweetClone = tweet.clone();
		var next = tweet.next();

		tweet.fadeTo(500, 0.00, function(){
			$(this).slideUp(250, function(){
				$(this).remove();		
			});
		});
	}	
	
	if (($("#pending_tweets .tweet").size() < 10) && approve)
	{
		getNewTweets();
	}
	
	return $(this);
	}
		
	});
	
function getNumTweets()
{
	console.log("Pending: " + $("#pending_tweets .tweet").size());
	console.log("Approved: " + $("#approved_tweets .tweet").size());	
}
	
var newTweet = function(userimage, text, id, username, user_id, img)
{
	var returnval;
	if (img != null)
		returnval = '<div class="tweet with_img" key="'+id+'"><div class="imgHover"><img class="user_img"  user="'+user_id+'" src="'+userimage+'" /><img class="user_img_hover" src="http://tweettwoscreens.com/assets/images/red_x.png" /></div><p><b>'+username+'</b><br />'+text+'</p><img class="delete" key="'+id+'" src="http://tweettwoscreens.com/assets/images/red_x.png" /><img class="approve" key="'+id+'"" src="http://tweettwoscreens.com/assets/images/approve.png" /><div class="tweeted_img"><img src="' + img + '"></div></div>';

	else 
		returnval = '<div class="tweet" key="'+id+'"><div class="imgHover"><img class="user_img"  user="'+user_id+'" src="'+userimage+'" /><img class="user_img_hover" src="http://tweettwoscreens.com/assets/images/red_x.png" /></div><p><b>'+username+'</b><br />'+text+'</p><img class="delete" key="'+id+'" src="http://tweettwoscreens.com/assets/images/red_x.png" /><img class="approve" key="'+id+'"" src="http://tweettwoscreens.com/assets/images/approve.png" /></div>';
			

	return returnval;
}
var lastTry = 0;
function getNewTweets() {

	if (($.now() - lastTry) > 20000)
	{
			lastTry = $.now();
			console.log($.now() - lastTry);
			$.getJSON("monitor/getNewTweets", function(tweet){

				$.each(tweet, function(data){
				$("#pending_tweets").append(newTweet(tweet[data]['user_img'], tweet[data]['message'], tweet[data]['id'], tweet[data]['username'], tweet[data]['user_id'], tweet[data]['img']));	
	
				});

			});
	}
	else
	{
		console.log($.now() - lastTry);
		console.log("failed new tweets");
	}

}
	

$(document).ready(function(){
	
	var autoApprove = setInterval(function(){
		$("#pending_tweets .tweet:first img.approve").approve();
	}, 5000);

	var autoDisplay = setInterval(function(){
		$("#approved_tweets .tweet:first img.approve").display();
	}, 6000);

	setInterval(function(){
		getNewTweets();
	}, 300000);
	

	getNewTweets();

    $("#tweet_deck").on('mouseenter', ".imgHover",
        
        function() {
            $(this).children("img").fadeTo(200, 1).end().children(".user_img_hover").show();
        });
        
    $("#tweet_deck").on('mouseleave', ".imgHover",
        
    	function() {
            $(this).children("img").fadeTo(200, 1).end().children(".user_img_hover").hide();

        });     
        
            
    $(".imgHover").live('click', function(){
    	var id = $(this).find('.user_img').attr('user');
			   	
			   	$(this).parent(".tweet").fadeTo(500, 0.00, function(){
				   	$(this).slideUp(250, function(){
					   	$(this).remove();		
					   	});
				});
    	
	   $.post('monitor/blacklistUserId', {'user_id':id}, function(data){
		   	var parsedData = $.parseJSON(data);
		   	$('#blacklist_user_dropdown').find("ol").append('<li>'+parsedData['username']+'</li><img class="dropdown_delete" type="blacklist" src="http://tweettwoscreens.com/assets/images/dropdown_x.png" />');
	   });
	   
	   
	   if ($("#pending_tweets .user_img").size() < 100)
	   {
		   $("#pending_tweets .user_img").each(function(index, tweet){
		   	if ($(tweet).attr('user') == id)
		   	{
			   	$(tweet).parent(".imgHover").parent(".tweet").fadeTo(500, 0.00, function(){
				   	$(this).slideUp(250, function(){
					   	$(this).remove();		
					   	});
				});
		   	}
			   	
			   	
	   	});
	   }
	   else
	   {
		   console.log("too many tweets to blacklist");
		   console.log($("#pending_tweets .user_img").size());
	   }

    });

	$("#question")
	  .focus(function() {
	        if (this.value === this.defaultValue) {
	            this.value = '';
	        }
	  })
	  .blur(function() {
	        if (this.value === '') {
	            this.value = this.defaultValue;
	        }
	        else
	        {
		        $.post('monitor/updateQuestion', {'question' : this.value});
		        this.defaultValue = this.value;
	        }
	});


	$(".dropdown_delete").live('click', function(){
		var li = $(this).prev('li');
		var word = li.text().trim();
		li.fadeOut(500);
		$(this).fadeOut(500);
		
		
		var type = $(this).attr('type');
		$.post('monitor/remove'+type, {'word' : word});
	});
	
	$(".dropdown_list input").keypress(function (e) {
		if (e.which == 13) {
			var type = $(this).attr('name');
			var word = $(this).val();
			$.post('monitor/add'+type, {'word': word});
			$(this).val('');
			$(this).next("ol").append('<li>'+word+'</li><img class="dropdown_delete" type="blacklist" src="http://tweettwoscreens.com/assets/images/dropdown_x.png" />');

		}
	});
	

	$(".settings_button").click(function(){
		var id = $(this).attr('id')		
		var dropdown = $("#"+id+"_dropdown").slideToggle();
	});



	$("#clear_pending").click(function(){
		var height = $("#pending_tweets").height();
		var i=0;
		var cleared = $("#pending_tweets .tweet:nth-child("+i+")").height();
		var newHeight = 1;
		while ((cleared < height) && newHeight)
		{
			$("#pending_tweets .tweet:nth-child("+i+") .delete").click();
			i++;
			newHeight = $("#pending_tweets .tweet:nth-child("+i+")").height();
			cleared += newHeight
		}
		if ($("#pending_tweets .tweet").size() <5)
		{

			getNewTweets();
		}
		
	});


	$("#approve_pending").click(function(){
		var height = $("#pending_tweets").height();
		var i=0;
		var cleared = $("#pending_tweets .tweet:nth-child("+i+")").height();
		var newHeight = 1;
		while ((cleared < height) && newHeight)
		{
			$("#pending_tweets .tweet:nth-child("+i+") .approve").click();
			i++;
			newHeight = $("#pending_tweets .tweet:nth-child("+i+")").height();
			cleared += newHeight
		}
		
	});


	$(".approve").live('click', function(){
		$(this).approve();
	} );
	
	$(".delete").live('click', function(){
	var tweet_id = $(this).attr('key');	
	$.post("monitor/deleteTweet", {"tweet_id": tweet_id});


	var tweet = $(this).parent();
	var tweetClone = tweet.clone();
	var next = tweet.next();

	tweet.fadeTo(500, 0.00, function(){
		$(this).slideUp(250, function(){
			$(this).remove();		
		});
	});
		

	});
	
	$("#settings_button").live('click', function(){
		$("#deck").slideToggle('slow');	
		$("#settings").slideToggle('slow');
	});
	
	$("span#approve_off.unselected").live('click', function(){
		clearInterval(autoApprove);
		$("span#approve_off").removeClass("unselected");
		$("span#approve_off").addClass("selected");
		$("span#approve_on").addClass("unselected");
		$("span#approve_on").removeClass("selected");
		$.post("monitor/updateSetting", {'column' : 'approve', 'value' : 0});
	});
	
		
	$("span#approve_on.unselected").live('click', function(){
		clearInterval(autoApprove);
		$("span#approve_on").removeClass("unselected");
		$("span#approve_on").addClass("selected");
		$("span#approve_off").addClass("unselected");
		$("span#approve_off").removeClass("selected");
		
		autoApprove = setInterval(function(){
		$("#pending_tweets .tweet:first img.approve").approve();
		}, 5000);
		$.post("monitor/updateSetting", {'column' : 'approve', 'value' : 1});
	});
	
	$("span#display_off.unselected").live('click', function(){
		clearInterval(autoDisplay);
		$("span#display_off").removeClass("unselected");
		$("span#display_off").addClass("selected");
		$("span#display_on").addClass("unselected");
		$("span#display_on").removeClass("selected");
		$.post("monitor/updateSetting", {'column' : 'display', 'value' : 0});		
	});
	
		
	$("span#display_on.unselected").live('click', function(){
		clearInterval(autoDisplay);
		$("span#display_on").removeClass("unselected");
		$("span#display_on").addClass("selected");
		$("span#display_off").addClass("unselected");
		$("span#display_off").removeClass("selected");
		
		autoDisplay = setInterval(function(){
		$("#approved_tweets .tweet:first img.approve").display();
		}, 10000);
		$.post("monitor/updateSetting", {'column' : 'display', 'value' : 1});		
	});

	

	if (approve == false)
		$('span#approve_off.unselected').click();

	if (display == false)		
		$('span#display_off.unselected').click();		
	

});