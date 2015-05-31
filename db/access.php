<?php
// We define a new capability, the ability to modify the bibliography2
$capabilities = array(

    'local/bibliography2:teacherview' => array(
    	// Capability type (write, read, etc.)
        'captype' => 'read',
        // Context in which the capability can be set (course, category, etc.)
        'contextlevel' => CONTEXT_COURSE,
        // Default values for different roles (only teachers and managers can modify)
        'archetypes' => array(
        	'student'=>CAP_PROHIBIT,
            'teacher' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        	'manager' => CAP_ALLOW
)));
?>