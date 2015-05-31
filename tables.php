<?php

class tables{
	
	public function __construct(){}
	
	public static function getBibliography($courseid, $bookValue, $addBookTrue){
		
		global $DB, $OUTPUT, $addBookTrue;
		
		$table = new html_table();
		$table->head = array('Title','Author','Copies','Rating','Actions');
		$context = context_course::instance($courseid);//context_system::instance();
		
		$detailIcon = new pix_icon("i/preview", "Details");
		$deleteIcon = new pix_icon("t/delete", "Delete");
		$editIcon = new pix_icon("t/edit", "Edit");
		
		
		$id_books = $DB->get_records('course_has_bibliography', array('id_course'=>$courseid));
		foreach($id_books as $id_book){
			$cellClass='';
			$books = $DB->get_records('local_bibliography', array('id'=>$id_book->id_book));
			foreach($books as $book){	
				$bookTitleCell = new html_table_cell($book->titulo);
				
					if($id_book->id_book == $bookValue){
						if($addBookTrue == TRUE){
						$cellClass = 'green';
					}else{
						$cellClass='red';
					}
				}
				
				$bookTitleCell->attributes['class'] = $cellClass;
				
				$detailUrl = new moodle_url($book->link);
				$detailButton = $OUTPUT->action_icon($detailUrl, $detailIcon);
		
		
				$deletelUrl = new moodle_url("/local/bibliography2/index.php", array('action'=>'delete_book', 'courseid'=>$courseid, 'id_book'=>$book->id));
		
				$editUrl = new moodle_url("/local/bibliography2/edit.php", array('courseid'=>$courseid, 'id_book'=>$book->id));
				if(has_capability('local/bibliography2:teacherview', $context)){
					$editButton = $OUTPUT->action_icon($editUrl, $editIcon);
					$deleteButton = $OUTPUT->action_icon($deletelUrl, $deleteIcon, new confirm_action("Seguro que desea borrar el libro: ".$book->titulo));
				}else{
					$editButton = '';
					$deleteButton = '';
				}
		
				$table->data[]= array($bookTitleCell, $book->autor,'25/90','3/5',$detailButton."".$deleteButton."". $editButton);
				}
		}
		return $table;
		
	}
}