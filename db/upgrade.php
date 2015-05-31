<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file keeps track of upgrades to the evaluaciones block
 *
 * Sometimes, changes between versions involve alterations to database structures
 * and other major things that may break installations.
 *
 * The upgrade function in this file will attempt to perform all the necessary
 * actions to upgrade your older installation to the current version.
 *
 * If there's something it cannot do itself, it will tell you what you need to do.
 *
 * The commands in here will all be database-neutral, using the methods of
 * database_manager class
 *
 * Please do not forget to use upgrade_set_timeout()
 * before any action that may take longer time to finish.
 *
 * @since 2.0
 * @package blocks
 * @copyright 2015 Dario Pfeng
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 *
 * @param int $oldversion
 * @param object $block
 */


function xmldb_local_bibliography2_upgrade($oldversion) {
	global $CFG, $DB;

	$dbman = $DB->get_manager();
	
    if ($oldversion < 2015051917) {

        // Define table local_bibliography to be created.
        $table = new xmldb_table('local_bibliography');

        // Adding fields to table local_bibliography.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('titulo', XMLDB_TYPE_CHAR, '1000', null, XMLDB_NOTNULL, null, null);
        $table->add_field('autor', XMLDB_TYPE_CHAR, '1000', null, XMLDB_NOTNULL, null, null);
        $table->add_field('lugar_y_editorial', XMLDB_TYPE_CHAR, '1000', null, XMLDB_NOTNULL, null, null);
        $table->add_field('fecha_de_publicacion', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('idioma', XMLDB_TYPE_CHAR, '100', null, XMLDB_NOTNULL, null, null);
        $table->add_field('numero_de_sistema', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('identificador_registro', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        
        // Adding keys to table local_bibliography.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
       
        // Conditionally launch create table for local_bibliography.
        if (!$dbman->table_exists($table)) {
        	$dbman->create_table($table);
        }
        
//         // Define table course_has_bibliography to be created.
//         $table = new xmldb_table('course_has_bibliography');
        
//         // Adding fields to table course_has_bibliography.
//         $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
//         $table->add_field('id_book', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
//         $table->add_field('course_id', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);

//         // Adding keys to table course_has_bibliography.
//         $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        
//         // Conditionally launch create table for course_has_bibliography.
//         if (!$dbman->table_exists($table)) {
//         	$dbman->create_table($table);
//         }

        // Bibliography2 savepoint reached.
        upgrade_plugin_savepoint(true, 2015051916, 'local', 'bibliography2');
    }
    
       if ($oldversion < 2015051921) {

        // Define table course_has_bibliography to be dropped.
        $table = new xmldb_table('course_has_bibliography');

        // Conditionally launch drop table for course_has_bibliography.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Bibliography2 savepoint reached.
        upgrade_plugin_savepoint(true, 2015051921, 'local', 'bibliography2');
    }
    
    if ($oldversion < 2015051922) {
    
    	// Define table course_has_bibliography to be created.
    	$table = new xmldb_table('course_has_bibliography');
    
    	// Adding fields to table course_has_bibliography.
    	$table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
    	$table->add_field('id_book', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
    	$table->add_field('id_course', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
    
    	// Adding keys to table course_has_bibliography.
    	$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
    
    	// Conditionally launch create table for course_has_bibliography.
    	if (!$dbman->table_exists($table)) {
    		$dbman->create_table($table);
    	}
    
    	// Bibliography2 savepoint reached.
    	upgrade_plugin_savepoint(true, 2015051922, 'local', 'bibliography2');
    }
    
    if ($oldversion < 2015052800) {
    
    	// Define table subjects to be created.
    	$table = new xmldb_table('subjects');
    
    	// Adding fields to table subjects.
    	$table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
    	$table->add_field('subjects', XMLDB_TYPE_CHAR, '1000', null, XMLDB_NOTNULL, null, null);
    
    	// Adding keys to table subjects.
    	$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
    
    	// Conditionally launch create table for subjects.
    	if (!$dbman->table_exists($table)) {
    		$dbman->create_table($table);
    	}
    
    	// Bibliography2 savepoint reached.
    	upgrade_plugin_savepoint(true, 2015052800, 'local', 'bibliography2');
    }
    
    if ($oldversion < 2015052801) {
    
    	// Define field subject_id to be added to local_bibliography.
    	$table = new xmldb_table('local_bibliography');
    	$field = new xmldb_field('subject_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null, 'identificador_registro');
    
    	// Conditionally launch add field subject_id.
    	if (!$dbman->field_exists($table, $field)) {
    		$dbman->add_field($table, $field);
    	}
    
    	// Bibliography2 savepoint reached.
    	upgrade_plugin_savepoint(true, 2015052801, 'local', 'bibliography2');
    }
    
    if ($oldversion < 2015053001) {
    
    	// Define field link to be added to local_bibliography.
    	$table = new xmldb_table('local_bibliography');
    	$field = new xmldb_field('link', XMLDB_TYPE_CHAR, '1000', null, XMLDB_NOTNULL, null, null, 'subject_id');
    
    	// Conditionally launch add field link.
    	if (!$dbman->field_exists($table, $field)) {
    		$dbman->add_field($table, $field);
    	}
    
    	// Bibliography2 savepoint reached.
    	upgrade_plugin_savepoint(true, 2015053001, 'local', 'bibliography2');
    }
	return true;
}
    
     
