<?php

require('../../../config.php');
require_once($CFG->dirroot.'/mod/jasmine/lib.php');
// require_once($CFG->dirroot.'/mod/page/locallib.php');
// require_once($CFG->libdir.'/completionlib.php');

$id      = optional_param('id', 0, PARAM_INT); // Course Module ID
$p       = optional_param('p', 0, PARAM_INT);  // Page instance ID
// $inpopup = optional_param('inpopup', 0, PARAM_BOOL);


if ($id) {
    $cm         = get_coursemodule_from_id('jasmine', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $quizgame  = $DB->get_record('jasmine', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $quizgame  = $DB->get_record('jasmine', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $quizgame->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('jasmine', $quizgame->id, $course->id, false, MUST_EXIST);
} else {
    print_error('invalidaccessparameter');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

// Print page
$PAGE->set_url('/mod/jasmine/api/students.php', array('id' => $cm->id));
$PAGE->set_title(format_string($quizgame->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);
// $PAGE->set_focuscontrol('mod_quizgame_game');
// $renderer = $PAGE->get_renderer('mod_jasmine');\

// echo $OUTPUT->header();
    // var_dump($context); die;
// var_dump(has_capability('mod/jasmine:viewadmin', $context));
// $test = array();
// $test[0] = 1;
// $test[1] = 2;
// $test[2] = 3;
// $test[3] = 4;
header('Content-Type: application/json');
echo json_encode(get_users_by_capability($context, 'mod/jasmine:view'));

// json_encode(get_users_by_capability($context, 'mod/jasmine:view'));
    // var_dump(get_users_by_capability($context, 'mod/jasmine:viewadmin'));
// if (has_capability('mod/jasmine:viewadmin', $context)) {
//     echo '<iframe src="http://localhost:3000/admin" name="jasmine-game" width="800" height="600" frameborder="0" scrolling="yes"></iframe>';
// if(has_capability('mod/jasmine:view', $context)) {
//     echo '<iframe src="http://localhost:3000/game" name="jasmine-game" width="800" height="600" frameborder="0" scrolling="no"></iframe>';
// } else {
//     echo 'ACCESS DENIED';
// }


// echo $OUTPUT->footer();