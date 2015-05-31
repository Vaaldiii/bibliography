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
$url = new moodle_url('/local/bibliography2/index.php', array('courseid'=>$courseid));
$urlAddBook = new moodle_url('/local/bibliography2/index.php', array('courseid'=>$courseid, 'action'=>'add_book'));
$urlBack = new moodle_url("/local/bibliography2/index.php",array("courseid"=>$courseid));
$context = context_course::instance($courseid);//context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

$bookValue = '';
$addBookTrue = FALSE;
$courseName = $DB->get_record('course', array('id'=>$courseid));
$action = optional_param('action', 'view_table', PARAM_TEXT);

//breadcrumbs
$PAGE->navbar->add($courseName->shortname,'/course/view.php?id='.$courseid);
$PAGE->navbar->add('Bibliography', '/local/bibliography2/index.php?courseid='.$courseid);
$PAGE->navbar->add('Add New Book');

/*echo '<div class="alert alert-danger">Borrado</div>';
echo '<div class="alert alert-info">Editado</div>';
echo '<div class="alert alert-success">Logrado</div>';*/

echo $OUTPUT->header();

if($action == 'add_book'){
	$title = "Add Book";
	$title2 = "Course Books";
	$PAGE->set_title($title);
	$PAGE->set_heading($title2);
	echo $OUTPUT->heading($title);
	
	$mform = new addBook($urlAddBook);
}

if($action == 'add_book'){
	if($fromform = $mform->get_data()){
		$agregar = '';
		$bookValue = $fromform->book;
		$checkDuplication = $DB->record_exists('course_has_bibliography', array('id_book'=>$bookValue));

		if($checkDuplication == FALSE){
			$agregar = $DB->insert_record('course_has_bibliography', array('id_course'=>$courseid, 'id_book'=>$bookValue));

		}else{
			echo '<div class="alert alert-danger">El libro que desea agregar ya esta!</div>';
		}
		if($agregar == TRUE){
			echo '<div class="alert alert-success">Agregado con éxito!</div>';
			$addBookTrue = TRUE;
		}
	}
	
	if(!$fromform){
		$mform->set_data($mform);
		$mform->display();
		echo $OUTPUT->single_button($urlBack , 'Back');
	}else{
		$table = tables::getBibliography($courseid, $bookValue, $addBookTrue);
		echo html_writer::table($table);
		echo $OUTPUT->single_button($urlAddBook , 'Add Another Book');
		echo $OUTPUT->single_button($urlBack , 'Back');
	}
}

if($action == 'delete_book'){
	$bookToDelete = required_param('id_book', PARAM_INT);
	$deleteBook = $DB->delete_records('course_has_bibliography', array('id_book'=>$bookToDelete, 'id_course'=>$courseid));
	if($deleteBook == TRUE){
	echo '<div class="alert alert-danger">Borrado con éxito!</div>';
	}
	$action = 'view_table';
}  	  


if($action == 'view_table'){
		$title = "Bibliography";
		$title2 = "Course Books";
		$PAGE->set_title($title);
		$PAGE->set_heading($title2);
		echo $OUTPUT->heading($title);
	
	$table = tables::getBibliography($courseid, $bookValue, $addBookTrue);
	$url2 = new moodle_url("/local/bibliography2/index.php",array("courseid"=>$courseid, 'action'=>'add_book'));
	echo $OUTPUT->single_button($url2 , 'Add New Book');
	echo html_writer::table($table);
}


echo $OUTPUT->footer();
?>
<script type="text/javascript" src="scripts/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="scripts/select_filter.js"></script>
