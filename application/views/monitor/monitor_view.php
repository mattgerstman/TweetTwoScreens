<script type="text/javascript">
var approve = <?php echo $settings->approve; ?>;
var display = <?php echo $settings->display; ?>;
</script>
<header>

<div id="deck"><img id="twitter_box" src='<?php echo base_url('assets/images/twitterbox.png');?>' /></div>
<div id="settings">
	<div id="settings_group">
		<div id="settings_left">
		
			<button id="keywords" class="settings_button">Keywords</button>	
			<button id="blacklist_words" class="settings_button">Blacklisted Words</button>
			<div class="dropdowns">
				<div id="keywords_dropdown" class="dark_dropdown">
					<div class="dropdown_list">
						<input type="text" name="keyword"/>
						<ol>
						<?php foreach($keywords as $keyword) {
						?>
	
							<li>
								<?php	
								echo $keyword->phrase;
								?>
							</li>
							<img src="<?php echo base_url('assets/images/dropdown_x.png');?>" class="dropdown_delete" type="keyword" />
						<?php
						
						} ?>
						</ol>
					</div>

					
				</div>
				<div id="blacklist_words_dropdown" class="light_dropdown">
					
					<div class="dropdown_list">
						<input type="text" name="profanity"/>
						<ol>
						<?php foreach($profanity as $swear) {
						?>
	
							<li>
								<?php	
								echo $swear->word;
								?>
							</li>
							<img src="<?php echo base_url('assets/images/dropdown_x.png');?>" class="dropdown_delete" type="profanity" />
						<?php
						
						} ?>
						</ol>
					</div>
					
					
				</div>			
			</div>
		</div>
		<div id="settings_center">
			<div id="title"><span>#DMatUF Panel</span></div>
			<div id="center_inputs">
				<textarea id="question"><?php echo $settings->question; ?></textarea>
			</div>
		</div>
		<div id="settings_right">	
			<button id="blacklist_user" class="settings_button">Blacklisted Users</button>		
			<button id="whitelist_user" class="settings_button">Whitelisted Users</button>	
			<div class="dropdowns">
				<div id="blacklist_user_dropdown" class="dark_dropdown">
					<div class="dropdown_list">
						<input type="text" name="blacklist"/>
						<ol>
						<?php foreach($blacklist as $user => $i) {
						?>
							<li>
								<?php	
								echo $user;
								?>
							</li>
							<img src="<?php echo base_url('assets/images/dropdown_x.png');?>" class="dropdown_delete" type="blacklist" />
						<?php
						
						} ?>
						</ol>
					</div>
					
					
				</div>				
				<div id="whitelist_user_dropdown" class="light_dropdown">
					<div class="dropdown_list">
						<input type="text" name="whitelist"/>
						<ol>
						<?php foreach($whitelist as $user => $i) {
						?> 
	
							<li>
								<?php	
								echo $user;
								?>
							</li>
							<img src="<?php echo base_url('assets/images/dropdown_x.png');?>" class="dropdown_delete" type="whitelist" />
						<?php
						
						} ?>
						</ol>
					</div>
								
					
					
				</div>	
			</div>
		</div>
	</div>
	<div id="panels"></div>
</div>
</header>

<nav id="settings_button">Settings</nav>

<div id="tweet_deck">
	
	<div id = "pending">
			<h2>Pending</h2>
			<h3>Auto Approve <span class="selected" id="approve_on">ON</span>/<span class="unselected" id="approve_off">OFF</span><img id="clear_pending" src="<?php echo base_url('assets/images/red_x.png');?>" /><img id="approve_pending" src="<?php echo base_url('assets/images/approve.png');?>" /></h3>

			<div class="box_left">

				<div id="pending_tweets">
				
				<?php
					foreach ($pendingTweets as $tweet)					
					{
						$id = $tweet['id'];
						$user_id = $tweet['user_id'];
						$userimage = $tweet['user_img'];
						$text = $tweet['message'];
						$username = $tweet['username'];
												
					?>	
						<div class="tweet <?php
						if(isset($tweet['img']))
						{
						echo ' with_img';
						}
						 ?>" key="<?php echo $id; ?>">
						 <div class="imgHover"><img class="user_img" user="<?php echo $user_id; ?>" src="<?php echo $userimage; ?>" /><img class="user_img_hover" src="http://tweettwoscreens.com/assets/images/red_x.png" /></div>
						 
						<p><b><?php echo $username; ?></b><br /><?php echo $text; ?>
						 </p><img class="delete" key="<?php echo $id; ?>" src="<?php echo base_url('assets/images/red_x.png');?>" /><img class="approve" key="<?php echo $id; ?>" src="http://tweettwoscreens.com/assets/images/approve.png" />
						<?php
						
						if (isset($tweet['img']))
						{ ?>
							
							<div class="tweeted_img"><img src="<?php echo $tweet['img']; ?>"></div>
							
						<?php }
						
						?>
						
						
						</div>
					<?php
					}
				?>
				
				</div>			
			</div>
	</div>
	
	<div id = "approved">
		<h2>approved</h2>
		<h3>Display <span class="selected" id="display_on">ON</span>/<span class="unselected" id="display_off">OFF</span></h3>
		<div class="box_right">
				<div id="approved_tweets">
				
				<?php
					foreach ($approvedTweets as $tweet)					
					{
						$id = $tweet['id'];
						$user_id = $tweet['user_id'];
						$userimage = $tweet['user_img'];
						$text = $tweet['message'];
						$username = $tweet['username'];						
												
					?>	
						<div class="tweet <?php
						if(isset($tweet['img']))
						{
						echo ' with_img';
						}
						 ?>" key="<?php echo $id; ?>"> <div class="imgHover"><img class="user_img" user="<?php echo $user_id; ?>" src="<?php echo $userimage; ?>" /><img class="user_img_hover" src="http://tweettwoscreens.com/assets/images/red_x.png" /></div>

<p><b><?php echo $username; ?></b><br /><?php echo $text; ?></p><img class="delete" key="<?php echo $id; ?>" src="<?php echo base_url('assets/images/red_x.png');?>" /><img class="approve" key="<?php echo $id; ?>" src="http://tweettwoscreens.com/assets/images/approve.png" />
						<?php
						
						if (isset($tweet['img']))
						{ ?>
							
							<div class="tweeted_img"><img src="<?php echo $tweet['img']; ?>"></div>
							
						<?php }
						
						?>
						
						
						</div>
					<?php
					}
				?>
				
				</div>		
			
		</div>
	</div>
</div>