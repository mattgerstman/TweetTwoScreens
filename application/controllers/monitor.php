<?php

class Monitor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('tweets_model');
		$this->load->model('settings_model');
		$this->load->helper('url');		
	}
	
	public function index()
	{
// 		$this->output->enable_profiler(TRUE);
		$useful = $this->tweets_model->getUsefulTweets();
		$data['approvedTweets'] = $useful['approved'];
		$data['pendingTweets'] = $useful['new'];
		$data['keywords'] = $this->tweets_model->get_keywords();
		$data['profanity'] = $this->tweets_model->get_user_profanity(CURRENT_USER); 
		$data['whitelist'] = $this->config->item(WHITELIST_CONFIG); 		
		$data['blacklist'] = $this->config->item(BLACKLIST_CONFIG); 		
		$data['settings'] = $this->settings_model->get_settings();

		$this->load->view('monitor/monitor_header');
		$this->load->view('monitor/monitor_view', $data);
	}
	
	public function swears()
	{
		$words = $this->tweets_model->get_profanity();
		$data = array(
			"words" => $words,		
		);
		$this->load->view('swears_header');	
		$this->load->view('swears', $data);
	}
	
	public function addProfanity()
	{
		$word = $this->input->post('word', false);
		$user = $this->input->post('user', false);
		if (!$user)
			$user = CURRENT_USER;
		echo $this->settings_model->add_profanity($word, $user);
	}
	
	public function removeProfanity()
	{
		$word = $this->input->post('word');
		echo $this->tweets_model->remove_profanity($word);
	}

	
	public function testNewTweets()
	{
		$tweets = $this->tweets_model->getNewTweets();
		echo '<pre>';
		print_r($tweets);
	}
	
	public function getNewTweets()
	{
//		$this->output->enable_profiler(TRUE);
		echo json_encode($this->tweets_model->getNewTweets());
	}
	
	
	
	public function approveTweet()
	{
		$tweet_id = $this->input->post('tweet_id');
		$this->tweets_model->approve_tweet($tweet_id);
	}
	
	public function displayTweet()
	{
		$tweet_id = $this->input->post('tweet_id');
		$this->tweets_model->display_tweet($tweet_id);
	}
	
	public function pendTweet()
	{
		$tweet_id = $this->input->post('tweet_id');
		$this->tweets_model->pend_tweet($tweet_id);
	}

	public function deleteTweet()
	{
		$tweet_id = $this->input->post('tweet_id');
		$this->tweets_model->delete_tweet($tweet_id);
	}

	public function getWhitelist()
	{
		echo json_encode($this->settings_model->get_whitelist());
	}
	
	public function addWhitelist()
	{
		$phrase = $this->input->post('word');
		echo $this->tweets_model->add_whitelist($phrase);
	}

	public function removeWhitelist()
	{
		$phrase = $this->input->post('word');
		echo $this->tweets_model->remove_whitelist($phrase);
	}


	
	public function removeBlacklist()
	{
		$phrase = $this->input->post('word');
		echo $this->tweets_model->remove_blacklist($phrase);
	}
	
	public function getKeywords()
	{
		echo json_encode($this->tweets_model->get_keywords());
	}
	
	public function addKeyword()
	{
		$phrase = $this->input->post('word');
		echo $this->tweets_model->add_keyword($phrase);
	}
	
	public function removeKeyword()
	{
		$phrase = $this->input->post('word');
		echo $this->tweets_model->remove_keyword($phrase);
	}
	
	
	public function blacklistUserId()
	{
		$user_id = $this->input->post('user_id');
		echo $this->tweets_model->add_blacklist_by_id($user_id);
	}

	public function updateQuestion()
	{
		$question = $this->input->post('question');
		echo $this->settings_model->update_question($question);
	}
	
	public function updateSetting()
	{
		$column = $this->input->post('column');
		$value = $this->input->post('value');		
		echo $this->settings_model->update_setting($column, $value);
	}
	
	public function tweets()
	{
	
		$this->load->library('twitteroauth', array(
		  
		));
		
		$method = 'http://search.twitter.com/search.json';
		
		$params = array(
		'q'        => '#mgtweettest',
		'rpp'      => 100,
		'lang'	   => 'en',
		'page'	   => 1,
		'include_entities' => 1
		);
				 
		$this->twitteroauth->request('GET', $method, $params, true, true);
		$this->load->library('twitterutilities');
		
		$tweets = json_decode($this->twitteroauth->response['response']);
		$tweets = $tweets->results;
		echo '<pre>';
		print_r($tweets);
			
	}
	
	public function getUsefulTweets()
	{
		$useful = $this->tweets_model->getUsefulTweets();
	}
	
	public function testProfanity()
	{
		echo '<pre>';
		if($this->config->item('G_Chappell',WHITELIST_CONFIG))
			echo 'test';
	}

}

?>