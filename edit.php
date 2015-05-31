<?php
require_once(dirname(__FILE__) . '/../../config.php'); //obligatorio
require_once($CFG->dirroot.'/local/bibliography2/tables.php');
require_once($CFG->dirroot.'/local/bibliography2/forms.php');


global $PAGE, $CFG, $OUTPUT, $DB, $COURSE;
$courseid = required_param('courseid', PARAM_INT);
$courseExists = $DB->record_exists('course', array('id'=>$courseid));
if(!$courseExists){
	print_error('No existe el curso!!');
}
require_login();
$url = new moodle_url('/local/bibliography2/edit.php', array('courseid'=>$courseid));
$urlAddBook = new moodle_url('/local/bibliography2/index.php', array('courseid'=>$courseid, 'action'=>'add_book'));
$urlBack = new moodle_url("/local/bibliography2/index.php",array("courseid"=>$courseid));
$context = context_course::instance($courseid);//context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

$bookValue = '';
$addBookTrue = FALSE;
$courseName = $DB->get_record('course', array('id'=>$courseid));

//breadcrumbs
$PAGE->navbar->add($courseName->shortname,'/course/view.php?id='.$courseid);
$PAGE->navbar->add('Bibliography', '/local/bibliography2/index.php?courseid='.$courseid);
$PAGE->navbar->add('Edit Book');


$title = "Edit Book";
$title2 = "Course Books";
$PAGE->set_title($title);
$PAGE->set_heading($title2);
echo $OUTPUT->header();
echo $OUTPUT->heading($title);

$bookToEdit = required_param('id_book', PARAM_INT);
$editForm = new editBook('edit.php?courseid='.$courseid.'&id_book='.$bookToEdit);

if($fromformEdit = $editForm->get_data()){
	$editBook = '';
	$bookValue = $fromformEdit->book;
	$checkDuplication = $DB->record_exists('course_has_bibliography', array('id_book'=>$bookValue));

	if($checkDuplication == FALSE){
		$editBook = $DB->update_record('course_has_bibliography', array('id'=>$bookToEdit, 'id_book'=>$bookValue, 'id_course'=>$courseid));

	}else{
		echo '<div class="alert alert-danger">El libro que desea agregar ya esta!</div>';
	}
	if($editBook == TRUE){
		echo '<div class="alert alert-success">Editado con éxito!</div>';
		$addBookTrue = TRUE;
	}
}

if(!$fromformEdit){
	$editForm->set_data($editForm);
	$editForm->display();
	echo $OUTPUT->single_button($urlBack , 'Back');
}else{
	$table = tables::getBibliography($courseid, $bookValue, $addBookTrue);
	echo html_writer::table($table);
	echo $OUTPUT->single_button($urlAddBook , 'Add Book');
	echo $OUTPUT->single_button($urlBack , 'Back');
}
	
echo $OUTPUT->footer();
?>
<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="scripts/select_filter.js"></script>