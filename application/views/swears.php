<div id="halfdeck"></div>

<div id="tweet_deck">
	<div id="container">
			<div class="newStuff">
				<h1>New Word</h1>

				<input type="text" id="newWord" />
				<button id="addWord">Add Item</button>
			</div>
			<div class="words">
				<?php

				foreach ($words as $word )
				{
					$word = $word->word;
					?>
					<div class="entireWord">
						<span><?php echo $word; ?></span><img src="<?php echo base_url('assets/images/delete.png');?>" class="deleteButton" word="<?php echo $word; ?>" id="delete<?php echo $word;?>" />
					</div>
					<?php

					} ?>
			</div>
	</div>
</div>

<script type = "text/javascript">

	$("#addWord").live('click', function(){
		var word = $("#newWord").val();

		var data = {
			"word" : word
		};
		$.post('addProfanity', data, function(id) {


			$(".words").append('<div class="entireWord"><span id="'+word+'Span">'+word+'</span>\
			<img src="assets/img/delete.png" class="deleteButton" word="'+word+'" id="delete'+word+'" /></div>');
		});
		$("#newWord").val('');

	});

		$('#newWord').keypress(function (e) {
	  if (e.which == 13) {
	    $("#addWord").click();
	  }
	});

	$(".deleteButton").live('click',function(){

		var id = $(this).attr('word');
		$(this).parent().fadeOut(500);
		var data = {
			"word" : id
		};
		$.post('removeProfanity', data);
	});


</script>
