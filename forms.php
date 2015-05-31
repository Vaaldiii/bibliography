<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once("$CFG->libdir/formslib.php");

class addBook extends moodleform{
	
	public function definition(){
		
		global $OUTPUT, $DB;
		
		$books = $DB->get_records('local_bibliography');
		$subjects = $DB->get_records('subjects');
		
		$mform =& $this->_form;
		$libros = array();
		$categorias = array('Selecciona para filtrar');
		
		foreach($subjects as $subject){
			$categorias = $categorias + array($subject->id => $subject->subjects);
		}
		
		foreach($books as $book){
			$libros = $libros + array($book->id => $book->titulo);
		}
		
		$selectSubject = $mform->addElement('select', 'subject','Subject:',$categorias);
		$selectBook = $mform->addElement('select', 'book', 'Book:', $libros);
		
		$mform->addElement('submit', 'submitbutton', 'Add Book');
		
	}
}

class editBook extends moodleform{

	public function definition(){

		global $OUTPUT, $DB;

		$books = $DB->get_records('local_bibliography');
		$subjects = $DB->get_records('subjects');

		$mform =& $this->_form;
		$libros = array();
		$categorias = array('Selecciona para filtrar');

		foreach($subjects as $subject){
			$categorias = $categorias + array($subject->id => $subject->subjects);
		}

		foreach($books as $book){
			$libros = $libros + array($book->id => $book->titulo);
		}

		$selectSubject = $mform->addElement('select', 'subject','Subject:',$categorias);
		$selectBook = $mform->addElement('select', 'book', 'Book:', $libros);

		$mform->addElement('submit', 'submitbutton', 'Edit Book');

	}
}