<?php

function jasmine_supports($feature) {
    switch($feature) {
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return false;
        case FEATURE_COMPLETION_HAS_RULES:
            return false;
        case FEATURE_MOD_INTRO:
            return false;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_USES_QUESTIONS:
            return false;
        case FEATURE_BACKUP_MOODLE2:
            return false;
        default:
            return null;
    }
}

function jasmine_add_instance(stdClass $jasmine, mod_jasmine_mod_form $mform = null) {
    global $DB;

    $jasmine->timecreated = time();

    return $DB->insert_record('jasmine', $jasmine);
}

function jasmine_update_instance(stdClass $jasmine, mod_jasmine_mod_form $mform = null) {
    global $DB;

    $jasmine->timemodified = time();
    $jasmine->id = $jasmine->instance;

    return $DB->update_record('jasmine', $jasmine);
}

function jasmine_delete_instance($id) {
    global $DB;

    if (! $quizgame = $DB->get_record('jasmine', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('jasmine', array('id' => $quizgame->id));
    // $DB->delete_records('quizgame_scores', array('quizgameid' => $quizgame->id));

    return true;
}


