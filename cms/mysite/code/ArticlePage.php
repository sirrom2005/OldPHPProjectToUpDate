<?php
/**
 * Defines the HomePage page type
 */
 
class ArticlePage extends Page {

   static $db = array(
		'Date' => 'Date',
		'Author' => 'Text'
   );
   
   static $has_one = array(
   );
   
   static $defaults = array(
    	'ProvideComments' => true
	);
   
    function getCMSFields() {
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Content.Main', $dateField = new DateField('Date','Article Date (for example: 20/12/2010)'), 'Content');
		$dateField->setConfig('showcalendar', true);
		$dateField->setConfig('dateformat', 'dd/MM/YYYY');
		
		$fields->addFieldToTab('Root.Content.Main', new TextField('Author','Author Name'), 'Content');
		
		return $fields;
    }
   
}
 
class ArticlePage_Controller extends Page_Controller {
     
}
?>