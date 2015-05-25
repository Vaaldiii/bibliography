<?php
require_once(dirname(__FILE__) . '/../../config.php'); //obligatorio
require_once($CFG->dirroot.'/local/bibliography2/forms.php');
require_once($CFG->dirroot.'/local/bibliography2/tables.php');

global $PAGE, $CFG, $OUTPUT, $DB;
require_login();
$courseid = required_param('courseid', PARAM_INT);
$courseExists = $DB->record_exists('course', array('id'=>$courseid));
if(!$courseExists){
	print_error('Course does not exist!');
}
$url = new moodle_url('/local/bibliography2/add_book.php?');
$context = context_system::instance();//context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

$addBookTrue = FALSE;
$courseName = $DB->get_record('course', array('id'=>$courseid));
$urlBack = new moodle_url("/local/bibliography2/index.php",array("courseid"=>$courseid));

$PAGE->navbar->add($courseName->shortname,'/course/view.php?id='.$courseid);
$PAGE->navbar->add('Bibliography', '/local/bibliography2/index.php?courseid='.$courseid);
$PAGE->navbar->add('Add New Book');

$title = "Add Book";
$PAGE->set_title($title);

echo $OUTPUT->header();
echo $OUTPUT->heading($title);

$mform = new addBook("/trunk/local/bibliography2/add_book.php?courseid=".$courseid);

if($mform->is_cancelled()){}

else if($fromform = $mform->get_data()){
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
		$table = tables::getBibliography($courseid, $bookValue, $addBookTrue);
		echo html_writer::table($table);
	}
}

$mform->set_data($mform);
$mform->display();


echo $OUTPUT->single_button($urlBack , 'Volver');

echo $OUTPUT->footer();
