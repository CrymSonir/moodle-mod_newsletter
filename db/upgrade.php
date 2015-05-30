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
 * This file keeps track of upgrades to the newsletter module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod_newsletter
 * @copyright  2013 Ivan Šakić <ivan.sakic3@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute newsletter upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_newsletter_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes

    // And upgrade begins here. For each one, you'll need one
    // block of code similar to the next one. Please, delete
    // this comment lines once this file start handling proper
    // upgrade code.

    // if ($oldversion < YYYYMMDD00) { //New version in version.php
    //
    // }

    // Lines below (this included)  MUST BE DELETED once you get the first version
    // of your module ready to be installed. They are here only
    // for demonstrative purposes and to show how the newsletter
    // iself has been upgraded.

    // For each upgrade block, the file newsletter/version.php
    // needs to be updated . Such change allows Moodle to know
    // that this file has to be processed.

    // To know more about how to write correct DB upgrade scripts it's
    // highly recommended to read information available at:
    //   http://docs.moodle.org/en/Development:XMLDB_Documentation
    // and to play with the XMLDB Editor (in the admin menu) and its
    // PHP generation posibilities.

    // Launch change of type for field
    if ($oldversion < 2015041400) {

        // Change status to be allowed to be null
        $table = new xmldb_table('newsletter_issues');
        $field = new xmldb_field('status', XMLDB_TYPE_TEXT, 'big', null, null, null, null, 'publishon');

        // Conditionally change field type
        if ($dbman->field_exists($table, $field)) {
            $dbman->change_field_type($table, $field);
        }

        // Forum savepoint reached.
        upgrade_mod_savepoint(true, 2015041400, 'newsletter');
    }   

    if ($oldversion < 2015041401) {
    
        // Change status to be allowed to be null
        $table = new xmldb_table('newsletter_issues');
        $field = new xmldb_field('delivered', XMLDB_TYPE_INTEGER, '4', null, XMLDB_NOTNULL, null, '0', 'status');
    
        // Conditionally change field type
        if ($dbman->field_exists($table, $field)) {
            $dbman->change_field_type($table, $field);
        }
    
        // Forum savepoint reached.
        upgrade_mod_savepoint(true, 2015041401, 'newsletter');
    }
    
    if ($oldversion < 2015053000) {
    
    	// Add field
    	$table = new xmldb_table('newsletter_subscriptions');
    
    	// Conditionally add field
    	$field = new xmldb_field('timesubscribed', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'health');
    	if (!$dbman->field_exists($table, $field)) {
    		$dbman->add_field($table, $field);
    	}
    	
    	// Add field
    	$field = new xmldb_field('timestatuschanged', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timesubscribed');
    	if (!$dbman->field_exists($table, $field)) {
    		$dbman->add_field($table, $field);
    	}
    	
    	// Add field
    	$field = new xmldb_field('subscriberid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timestatuschanged');
    	if (!$dbman->field_exists($table, $field)) {
    		$dbman->add_field($table, $field);
    	}
    	
    	// Add field
    	$field = new xmldb_field('unsubscriberid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'subscriberid');
    	if (!$dbman->field_exists($table, $field)) {
    		$dbman->add_field($table, $field);
    	}
    
    	// Newsletter savepoint reached.
    	upgrade_mod_savepoint(true, 2015053000, 'newsletter');
    }
    // Third example, the next day, 2007/04/02 (with the trailing 00), some actions were performed to install.php,
    // related with the module
    // And that's all. Please, examine and understand the 3 example blocks above. Also
    // it's interesting to look how other modules are using this script. Remember that
    // the basic idea is to have "blocks" of code (each one being executed only once,
    // when the module version (version.php) is updated.

    // Lines above (this included) MUST BE DELETED once you get the first version of
    // yout module working. Each time you need to modify something in the module (DB
    // related, you'll raise the version and add one upgrade block here.

    // Final return of upgrade result (true, all went good) to Moodle.
    return true;
}
