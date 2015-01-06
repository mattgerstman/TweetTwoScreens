<?php

class Settings_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_whitelist()
	{
		$whitelist = $this->db->get(WHITELIST_TABLE)->result();
		return $whitelist;
	}	

	public function add_profanity($word, $user) {
		$data = array(
			'word'		=> $word,
			'user'		=> $user
		);
		$insert_query = $this->db->insert_string(PROFANITY_TABLE, $data);
		$insert_query = str_replace('INSERT INTO', 'INSERT IGNORE INTO', $insert_query);
		return $this->db->query($insert_query);	
	}

	public function update_setting($column, $value)
	{
		$data = array(
			$column => $value,
		);
				
		return $this->db->update(SETTINGS_TABLE, $data);

	}
	

	public function update_question($question)
	{
		if (($question == '') || ($question == NULL))
			$question = "Question of the moment...";

		$data = array(
			'question' => $question,
		);
		return $this->db->update(SETTINGS_TABLE, $data);

	}
	
	public function get_settings()
	{
		$settings = $this->db->get(SETTINGS_TABLE)->result();

		$question = &$settings[0]->question;

		if (($question == '') || ($question == NULL))
			$question = "Question of the moment...";

		return $settings[0];

	}

	public function get_question()
	{
		$settings = $this->db->get(SETTINGS_TABLE)->result();

		$question = $settings[0]->question;

		return $question;

	}

}
?>