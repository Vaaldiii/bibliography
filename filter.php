<?php
require_once(dirname(__FILE__) . '/../../config.php');

global $CFG, $DB;

$filter = $_REQUEST['filter'];
$selectBook = $DB->get_records_sql("SELECT titulo FROM mdl_local_bibliography WHERE subject_id LIKE '%".$filter."%'");
echo json_encode($selectBook);
?>