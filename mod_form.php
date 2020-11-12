<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}
 
require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/jasmine/lib.php');
 
class mod_jasmine_mod_form extends moodleform_mod {
    public function definition() {
        global $CFG, $COURSE;

        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are showed.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', 'Jasmine Game Title', array('size' => '64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        // $mform->addHelpButton('name', 'quizgamename', 'quizgame');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            $this->add_intro_editor();
        }

        $mform->addElement('text', 'server_url', 'Server URL'); // Add elements to your form
        $mform->setType('server_url', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('server_url', 'http://localhost:3000');        //Default value
        // $context = context_course::instance($COURSE->id);
        // $categories = question_category_options(array($context), false, 0);

        // $mform->addElement('selectgroups', 'questioncategory', get_string('questioncategory', 'quizgame'), $categories);
        // $mform->addHelpButton('questioncategory', 'questioncategory', 'quizgame');

        // Add standard elements, common to all modules.
        $this->standard_coursemodule_elements();
        // Add standard buttons, common to all modules.
        $this->add_action_buttons();
    }
}