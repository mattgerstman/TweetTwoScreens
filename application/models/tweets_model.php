<?php

class Tweets_model extends CI_Model {

	
	public function __construct()
	{
		$this->load->database();
		$this->_load_profanity();
		$this->_load_userlists();
	}
	
	private function _log($log)
	{
		echo '<script type="text/javascript"> console.log("' . $log . '"); </script>';
	}
	
	private function _load_userlists()
	{
	
		$whitelist = $this->db->get(WHITELIST_TABLE)->result();
		$whitelist_table = array();
		
		foreach ($whitelist as $user)
		{	
			$whitelist_table[$user->username] = true;
		}
		$this->config->set_item(WHITELIST_CONFIG, $whitelist_table);
		
		
		$blacklist_table = array();		
		$blacklist = $this->db->get(BLACKLIST_TABLE)->result();
		foreach ($blacklist as $user)
		{	
			$blacklist_table[$user->username] = true;
		}
		$this->config->set_item(BLACKLIST_CONFIG, $blacklist_table);
	}
	
	private function _load_profanity()
	{
		$profanity = $this->db->get(PROFANITY_TABLE)->result();
		$profanity_table = array();
		foreach ($profanity as $word)
		{	
			if (substr_count($word->word, ' ') == 0)
			{
				$profanity_table[$word->word] = true;	
			}
			else
			{
				$wordArray = explode(" ", $word->word);
				if ((!isset($profanity_table[$wordArray[0]]) || (gettype($profanity_table[$wordArray[0]]) == "array")))
				{
					$profanity_table[$wordArray[0]][] = $wordArray[1];
				}					
			}
				
		}
		$this->config->set_item(PROFANITY_CONFIG, $profanity_table);
	}
	
	private function _update_count($id, $count)
	{
		$retweet_data = array(
			'id' => $id,
			'retweets' => $count
		);
		return $retweet_data;
		
	}
	
	
	private function _retweet($tweet)
	{
		//gather retweet info
		$retweet = $tweet->retweeted_status;
		$retweet_id= $tweet->retweeted_status->id;
		$retweet_count = $tweet->retweeted_status->retweet_count;
		
		$data = array();
		$data = $this->_insert_tweet($retweet);
		$data['retweet'] = array(
			'id' => $retweet_id,
			'retweets' => $retweet_count);
		return $data;

								
	}
	
	private function _insert_user($tweet)
	{
		$data = array(
			'id'		=> $tweet->user->id,
			'image'		=> $tweet->user->profile_image_url,
			'username'	=> $tweet->user->screen_name);
			
//		$insert_query = $this->db->insert_string(USER_TABLE, $data);
//		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
//		return $this->db->query($insert_query);	
		return $data;
			
	}
	
	private function _insert_tweet($tweet)
	{
		$data['user'] = $this->_insert_user($tweet);
		$data['tweet'] = array(
			'id' 		=> $tweet->id,
			'message' 	=> trim(preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $tweet->text)),
			'user_id' 	=> $tweet->user->id,
			'retweets' 	=> $tweet->retweet_count,
			'approved' => 0,
			'pending' => 0,	
			'img' => null		
		);

		if ($this->whitelisted($tweet->user->screen_name))
		{
			$data['tweet']['retweets'] = ($tweet->retweet_count +1)*1000;
			$data['tweet']['approved'] = true;
			$data['tweet']['pending'] = true;	

		}
			
		if (isset($tweet->entities->media[0]->media_url))
		{
			$data['tweet']['img'] = $tweet->entities->media[0]->media_url;
			$data['tweet']['retweets'] = ($data['tweet']['retweets'] + 1) * 10;
		}
			
		
		
			
		
//		$insert_query = $this->db->insert_string(TWEET_TABLE, $data);
//		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
//		return $this->db->query($insert_query);	
		return $data;

	}
	
	private function _is_profane($word) {
		$check = $this->config->item($word, PROFANITY_CONFIG);
		return $check;
    }
    
    
    private function _no_profanity($tweet)
    {
		$result = "";
		//turn the $string into an array of words	
		$text = strtolower($tweet->text);
		$tweetarray = explode(" ", $text);
		foreach ($tweetarray as $word) {
			
			if (gettype($this->_is_profane($word)) == "array")
			{
				if (in_array(current($tweetarray), $this->_is_profane($word)))
				{
					return false;
				}
			}
			else if ($this->_is_profane($word))
			{
				return false;
			}	
				
		}
		return true;
    }
    
    private function _query_tweets($num=100)
    {
	    $this->load->library('twitteroauth', array());
		$query = $this->get_query();		
		$method = 'https://api.twitter.com/1.1/search/tweets.json';
		
		$params = array(
		'q'        => $query,
		'count'      => $num,
		'lang'	   => 'en',
		'include_entities' => 1
		);
				 
		$this->twitteroauth->request('GET', $method, $params);
		$this->load->library('twitterutilities');

		$tweets = json_decode($this->twitteroauth->response['response']);


		if (isset($tweets -> statuses))
		{
			$tweets = $tweets -> statuses;
			$this->tweets_model->insert_tweets($tweets);
		}
		else
		{
			return false;
		}
    }
    
    
	public function get_query()
	{
		$keywords = $this->tweets_model->get_keywords();
		$query = "";
		foreach ($keywords as $keyword)
		{
			if ($query != "")
				$query.=" OR ";
			
			$query.= '"' . $keyword -> phrase .'"';
		}
		return $query;
	}
	
	public function getNewTweets($num=100)
	{
		$i = 0;
		do
		{
			$this->db->select('*, tweets.id');
			$this->db->join('users', 'users.id = tweets.user_id');
			$this->db->where(array("approved"=> 0,
			"banned" => 0));
			$this->db->order_by('retweets', 'desc');
			$tweets = $this->db->get(TWEET_TABLE)->result();			
	
			if (count($tweets) < 10)
			{
				$this->_query_tweets($num);
			}
			$i++;
			if ($i==5)
				return array();
		} while(count($tweets) == 0);

		$this->db->trans_start();
		
		$returnVal = array();
		foreach ($tweets as $tweet)
		{
			if ($tweets !=null)
			{
				$returnVal[] = array(
					'id'		=>	$tweet->id,
					'message'	=>	$tweet->message,
					'user_img'	=>	$tweet->image,
					'user_id'	=>	$tweet->user_id,
					'img'		=>	$tweet->img,
					'username'	=>	$tweet->username
							
				);
				
			}
		}
		$this->db->trans_complete();

		return $returnVal;
	}
	
	public function getUsefulTweets()
	{
		$this->db->select('*, tweets.id');
		$this->db->join('users', 'users.id = tweets.user_id');
		$this->db->where(array('pending'=> 0,
			"banned" => 0));
		$this->db->order_by("retweets", "desc");
		$tweets = $this->db->get(TWEET_TABLE)->result();
		
		$returnVal = array(
			'approved' => array(),
			'new' => array()
		);
		foreach ($tweets as $tweet)
		{
			if ($tweets !=null)
			{
				if ($tweet->approved)
				{
					
					$returnVal['approved'][] = array(
						'id'		=>	$tweet->id,
						'message'	=>	$tweet->message,
						'user_img'	=>	$tweet->image,
						'user_id'	=>	$tweet->user_id,
						'img'		=>	$tweet->img	,
						'username'	=>	$tweet->username	
					);
				}
				else
				{
					$returnVal['new'][] = array(
						'id'		=>	$tweet->id,
						'message'	=>	$tweet->message,
						'user_img'	=>	$tweet->image,
						'user_id'	=>	$tweet->user_id,
						'img'		=>	$tweet->img	,
						'username'	=>	$tweet->username	
					);
				}
			}
			
		}
		return $returnVal;
	
	}
	
	public function getApprovedTweets()
	{
		$this->db->select('*');
		$this->db->join('users', 'users.id = tweets.user_id');

		$this->db->order_by("retweets", "desc");
		$this->db->where(array(
								"approved"	=> 	1,
								'pending' => 0,
								"banned" => 0
								
							  ));
		$tweets = $this->db->get(TWEET_TABLE)->result();
		
		$returnVal = array();
		foreach ($tweets as $tweet)
		{
			if ($tweets !=null)
			{
				$returnVal[] = array(
					'id'		=>	$tweet->id,
					'message'	=>	$tweet->message,
					'user_img'	=>	$tweet->image,
					'user_id'	=>	$tweet->user_id,
					'img'		=>	$tweet->img	,
					'username'	=>	$tweet->username	
				);
			}
		}
		return $returnVal;
	}

    
    
	
	public function blacklisted($user_name)
	{
		return $this->config->item(strtolower($user_name), BLACKLIST_CONFIG);
	}
	
	
	public function whitelisted($user_name)
	{
		return $this->config->item(strtolower($user_name), WHITELIST_CONFIG);
	}
	
	public function insert_tweets($tweets)
	{
		$this->db->trans_start();
		$insert = array(
			'tweets' => array(),
			'users' => array(),
			'retweets' => array()
		);
		foreach ($tweets as $tweet) //loop through all tweets
		{
			if ((!$this->blacklisted($tweet->user->screen_name) && ($this->_no_profanity($tweet))) || $this->whitelisted($tweet->user->screen_name))
			{
				if (property_exists($tweet, 'retweeted_status'))
				{
					$retweet = $this->_retweet($tweet);
					$insert['retweets'][] = $retweet['retweet'];
					$insert['users'][] = $retweet['user'];
					$insert['tweets'][]= $retweet['tweet'];
				}
				else
				{
					
					$data = $this->_insert_tweet($tweet);
					$insert['users'][]= $data['user'];
					$insert['tweets'][]= $data['tweet'];
					
					//$insert_query = $this->db->insert_string(USER_TABLE, $data);
					//$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
				}	

			}

		}

		$this->db->insert_batch(TWEET_TABLE, $insert['tweets'], null, true);
		$this->db->insert_batch(USER_TABLE, $insert['users'], null, true);
		if (isset($insert['retweets'][0]))
			$this->db->update_batch(TWEET_TABLE, $insert['retweets'], 'id');
		$this->db->trans_complete();
		
		
	}
	
	public function get_user_profanity($user)
	{
		$this->db->where(array("user"=> $user));
		return $this->db->get(PROFANITY_TABLE)->result();			
	
	}
	
	public function get_user_blacklist()
	{
		return $this->db->get(BLACKLIST_TABLE)->result();			
	}

	public function get_user_whitelist()
	{
		return $this->db->get(WHITELIST_TABLE)->result();			
	}
	
	
	public function get_keywords()
	{
		return $this->db->get(KEYWORD_TABLE)->result();
	}
	
	public function add_keyword($phrase)
	{
		$data = array(
			'phrase' => $phrase
		);
		$insert_query = $this->db->insert_string(KEYWORD_TABLE, $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);		
		return $this->db->query($insert_query);	
		
	}
	
	public function remove_keyword($phrase)
	{
		$data = array(
			'phrase' => $phrase
		);
		$this->db->where($data);
		$this->db->delete(KEYWORD_TABLE);
	}	
	
	public function remove_profanity($word)
	{
		$data = array(
			'word' => $word
		);
		$this->db->where($data);
		$this->db->delete(PROFANITY_TABLE);
	}	
	
	public function add_whitelist($username)
	{
		$data = array(
			'username' => $username
		);
		$insert_query = $this->db->insert_string(WHITELIST_TABLE, $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);		
		return $this->db->query($insert_query);	
		
	}
	
	public function remove_whitelist($username)
	{
		$data = array(
			'username' => $username
		);
		$this->db->where($data);
		$this->db->delete(WHITELIST_TABLE);
	}	
	
	
	public function add_blacklist($username)
	{
		$data = array(
			'username' => $username
		);
		$insert_query = $this->db->insert_string(BLACKLIST_TABLE, $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);		
		return $this->db->query($insert_query);	
		
	}
	
	public function add_blacklist_by_id($user_id)
	{
		$data = array(
			'id' => $user_id
		);
		
		$this->db->where($data);
		$username = $this->db->get(USER_TABLE)->result();
		$username = $username[0]->username;
		$success = $this->add_blacklist($username);
		echo json_encode(array(
			'username' => $username,
			'success' => $success
		));
		
		
	}	
		
	public function remove_blacklist($username)
	{
		$data = array(
			'username' => $username
		);
		$this->db->where($data);
		$this->db->delete(BLACKLIST_TABLE);
	}	
	
	
	public function display_tweet($tweet_id)
	{
		$data = array(
			'displayed' => 1,
		);
		$this->db->where('id', $tweet_id);
		$this->db->update(TWEET_TABLE, $data);

	}
	
	public function pend_tweet($tweet_id)
	{
		$data = array(
			'pending' => 1
		);
		$this->db->where('id', $tweet_id);
		$this->db->update(TWEET_TABLE, $data);

	}

	public function approve_tweet($tweet_id)
	{
		$data = array(
			'approved' => 1
		);
		$this->db->where('id', $tweet_id);
		$this->db->update(TWEET_TABLE, $data);
	}
	
	public function delete_tweet($tweet_id)
	{

		$this->db->where('id', $tweet_id);
		$this->db->update(TWEET_TABLE, array(
		"banned" => 1));
	}
	
	public function get_pending_tweets($num)
	{
	
		$this->_query_tweets(100);
		$where = array('approved' =>1,
			'pending'=> 1,
			'displayed'=> 0,
			"banned" => 0);
	
		$this->db->select('*, tweets.id');	
		$this->db->join('users', 'users.id = tweets.user_id');
		$this->db->where($where);
		$this->db->order_by('retweets', 'desc');
		$pendingTweets = $this->db->get(TWEET_TABLE, $num)->result();
		$ids = array();
		
		foreach ($pendingTweets as $pTweet)
		{
			$ids[] = $pTweet->id;
		}
		$this->mark_used($ids);
	
		if (empty($pendingTweets))
		{
			$this->db->select('*, tweets.id');	
			$this->db->join('users', 'users.id = tweets.user_id');
			$this->db->where(array(
				"pending" => 1,
				"banned" => 0,
			));
			$this->db->order_by('tweets.id', 'rand');
			$this->db->limit(25);
			$pendingTweets = $this->db->get(TWEET_TABLE, $num)->result();
		}
		return $pendingTweets;
	}
	
	public function mark_used($tweets)
	{
		if (count($tweets) == 0)
		{
//			echo 'no tweets';
			return false;
		}
			
		$where = array();
		foreach ($tweets as $tweet)	
		{
			$this->db->or_where(array('id' => $tweet));
		}
		$data = array(
			'displayed' => 1,
		);
		$this->db->update(TWEET_TABLE, $data);
	}

	public function get_profanity()
	{
		$this->db->order_by("word", "asc");
		return $this->db->get(PROFANITY_TABLE)->result();
	}

}
?>