<?php

//use gradereport_singleview\local\screen\select;
require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->libdir/formslib.php");

class addBook extends moodleform{
	
	public function definition(){
		
		global $OUTPUT, $DB;
		
		$subject = $DB->get_records('local_bibliography');
		
		$mform =& $this->_form;
		$libros = array();
		foreach($subject as $subjects){
			$libros = $libros + array($subjects->id => $subjects->titulo);
		}
		
		$select = $mform->addElement('select', 'book', 'Book:', $libros);
		
		$mform->addElement('submit', 'submitbutton', 'Add Book');
		
	}
}