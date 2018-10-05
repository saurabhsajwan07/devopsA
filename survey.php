<?php

/* Copyright 2018 Atos SE and Worldline
 * Licensed under MIT (https://github.com/????/LICENSE)

MVP: 

- Prepare readme file
- Upload to Github
- Add results button to last page of survey
- Order spider diagram based on config
- Re-style questions a bit (inc section heading)
- Make navbar work (form submission when required), show current active page
- Create page to render CSV file
- On results page show the top 3 areas and the bottom 3 areas
- Icon for video, blog and book on results page
- Make advice configurable in json file
- Create detailed report page for sub categories
- Create about page which includes link to Github
 
 */

session_name('devopsassessment');
session_start();

Class Survey
{
	public $sections;

	public function __construct() 
	{
		// Load all the questions into session storage if we haven't already done so
		if (!isset($_SESSION['Sections'])) {
			$json = file_get_contents("questions.json");
			$_SESSION['Sections'] = json_decode($json, true);
		}
		$this->sections = &$_SESSION['Sections'];
		$this->SetupAnswerIDs(); // TODO: This should only be called first time we setup the Sections sesssion variable
		$this->SaveResponses();
	}
	
	public function GenerateResultsSummary()
	{
		foreach ($this->sections as $section)
		{
			$summaryResults[$section['SectionName']] = array('MaxScore'=>0, 'Score'=>0, 'ScorePercentage'=>0);
			
			foreach ($section['Questions'] as $question)
			{
				$summaryResults[$section['SectionName']]['MaxScore'] += $this->GetQuestionMaxScore($question); 
				$summaryResults[$section['SectionName']]['Score'] += $this->GetQuestionScore($question);
			}
			
			if ( $summaryResults[$section['SectionName']]['MaxScore'] != 0 )
			{
				$summaryResults[$section['SectionName']]['ScorePercentage'] = 
					round( $summaryResults[$section['SectionName']]['Score'] /
							$summaryResults[$section['SectionName']]['MaxScore'] * 100);
			}
			
			// Do not include sections where you cannot score (i.e. MaxScore == 0)
			if ( $summaryResults[$section['SectionName']]['MaxScore'] == 0 )
			{
				unset($summaryResults[$section['SectionName']]);
			}
		}
		
		return $summaryResults;
	}
	
	private function GetQuestionMaxScore($question)
	{
		$maxScore = 0;
		if ($question['Type'] != 'Banner')
		{
			foreach ($question['Answers'] as $answer)
			{
				if ($question['Type'] == 'Option')
				{
					if ($answer['Score'] > $maxScore)
					{
						$maxScore = $answer['Score'];
					}
				}
				if ($question['Type'] == 'Checkbox')
				{
					$maxScore += $answer['Score'];
				}
			}
		}
		
		return $maxScore;
	}

	private function GetQuestionScore($question)
	{
		$score = 0;
		if ($question['Type'] != 'Banner')
		{
			foreach ($question['Answers'] as $answer)
			{
				if ($answer['Value'] == 'checked')
				{
					$score += $answer['Score'];
				}
			}
		}
		
		return $score;
	}
	
	private function SetupAnswerIDs()
	{	
		// Loop through the model and assign a unique ID to each question and answer to assist with form rendering and submission
		foreach ($this->sections as $sectionIndex=>&$section)
		{
			foreach ($section['Questions'] as $questionIndex=>&$question)
			{
				if ( $question['Type'] != 'Banner')
				{
					$question['ID'] = 'S' . ($sectionIndex + 1) . '-Q' . ($questionIndex + 1);
					
					if ( !isset($question['Answers']) )
					{
						// Add default yes/no answers
						$question['Answers'] = array( array('Answer' => 'Yes', 'Score' => 1), array('Answer' => 'No', 'Score' => 0) );
					}
					
					foreach ($question['Answers'] as $answerIndex=>&$answer)
					{
						$answer['ID'] = 'S' . ($sectionIndex + 1) . '-Q' . ($questionIndex + 1) . '-A' . ($answerIndex + 1);
						if (!isset($answer['Value']))
						{
							$answer['Value'] = '';
						}
					}
				}
			}
		}
	}
	
	private function SaveResponses()
	{	
		// Loop through each question in our session storage and, if we find post variable matching the question ID, then save the answer
		foreach ($this->sections as $sectionIndex=>&$section)
		{
			foreach ($section['Questions'] as $questionIndex=>&$question)
			{
				if ( $question['Type'] == 'Option' )
				{
					if ( isset($_POST[$question['ID']]) )
					{
						foreach ($question['Answers'] as $answerIndex=>&$answer)
						{
							if ( $answer['ID'] == $_POST[$question['ID']] )
							{
								$answer['Value'] = 'checked';
							}
							else
							{
								$answer['Value'] = '';
							}
						}
					}
				}
				
				if ( $question['Type'] == 'Checkbox' )
				{
					foreach ($question['Answers'] as $answerIndex=>&$answer)
					{
						// If hidden field is there then we can use the presense of the non-hidden field to determine if the checkbox was checked
						if ( isset($_POST[$answer['ID'] . '-hidden']) )
						{
							if ( isset($_POST[$answer['ID']] ) )
							{
								$answer['Value'] = 'checked';
							}
							else
							{
								$answer['Value'] = '';
							}
						}
					}
				}
			}
		}
	}
	
}

?>