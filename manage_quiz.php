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

require_capability('mod/jasmine:viewadmin', $context);

// Print page
$PAGE->set_url('/mod/jasmine/manage_quiz.php', array('id' => $cm->id));
$PAGE->set_title('Manage Quiz Question');
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);
// $PAGE->set_focuscontrol('mod_quizgame_game');
// $renderer = $PAGE->get_renderer('mod_jasmine');\

// var_dump($cm); die;

$users = get_enrolled_users($context, 'mod/jasmine:viewstudent');
$templUsr = array();

foreach ($users as $user) {
    array_push($templUsr, ["id" => $user->id, "name" => $user->firstname . " " . $user->lastname]);
}

$templatecontext = (object) [
    'server_url' => 'http://localhost:3000',
    'class_id' => $cm->id,
    'server_url' => $jasmine->server_url,
    'students' => $templUsr,
    'spinner_url' => new moodle_url('/mod/jasmine/pix/spinner.gif')
];

echo $OUTPUT->header();

// echo 'Hello World';
echo $OUTPUT->render_from_template('mod_jasmine/manage_quiz', $templatecontext);

echo $OUTPUT->footer();