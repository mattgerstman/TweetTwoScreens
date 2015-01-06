<?php

class Display extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('tweets_model');
		$this->load->model('settings_model');
	}
	
	
	public function index()
	{
		$data['tweets'] = $this->tweets_model->get_pending_tweets(10);
		$data['question'] = $this->settings_model->get_question();
//		echo '<pre>';		

//		print_r($data);

		$this->load->helper('url');
		$this->load->view('display/display_header', $data);
		$this->load->view('display/display_view', $data);
	}

	public function getPendingTweets()
	{
// 		$this->output->enable_profiler(TRUE);	
		echo json_encode($this->tweets_model->get_pending_tweets(5));
	}	

	public function testPendingTweets()
	{
// 		$this->output->enable_profiler(TRUE);	
		//echo '<pre>';
		$this->tweets_model->get_pending_tweets(100);
	}	
	
	public function question()
	{
		echo $this->settings_model->get_question();
	}
	
	public function getQuestion()
	{
		echo "<html>";
		echo json_encode($this->settings_model->get_question());
	}
}