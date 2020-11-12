<?php

require('../../config.php');
require_once($CFG->dirroot.'/mod/jasmine/lib.php');

$id      = optional_param('id', 0, PARAM_INT); // Course Module ID
$p       = optional_param('p', 0, PARAM_INT);  // Page instance ID


if ($id) {
    $cm         = get_coursemodule_from_id('jasmine', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $jasmine = $DB->get_record('jasmine', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $jasmine = $DB->get_record('jasmine', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $jasmine->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('jasmine', $jasmine->id, $course->id, false, MUST_EXIST);
} else {
    print_error('invalidaccessparameter');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

// Print page
$PAGE->set_url('/mod/jasmine/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($jasmine->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// echo $OUTPUT->footer();

$templatecontext = (object) [
    'user_id' => $USER->id,
    'is_student' => has_capability('mod/jasmine:viewstudent', $context),
    'is_admin' => has_capability('mod/jasmine:viewadmin', $context),
    'manage_url' => new moodle_url('/mod/jasmine/manage.php', array('id' => $cm->id)),
    'manage_quiz_url' => new moodle_url('/mod/jasmine/manage_quiz.php', array('id' => $cm->id)),
    'server_url' => $jasmine->server_url
];

echo $OUTPUT->header();

echo $OUTPUT->render_from_template('mod_jasmine/view', $templatecontext);

echo $OUTPUT->footer();