<?php

defined('MOODLE_INTERNAL') || die();

class mod_jasmine_renderer extends plugin_renderer_base {
    public function render_game($quizgame, $context) {
        $display = '<iframe src="https://wanted5games.com/games/html5/football-io-new-en-s-iga-cloud/index.html?pub=10" name="cloudgames-com" width="775" height="480" frameborder="0" scrolling="no"></iframe>';


        return $display;
    }
}