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
 * Advanced calculator block.
 *
 * @package    block_advanced_calculator
 * @copyright  2024 Toni Jokinen <toni.o.jokinen@helsinki.fi>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_advanced_calculator extends block_base {

    /**
     * Initialize the block.
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_advanced_calculator');
    }

    /**
     * Return the content of the block.
     *
     * @return stdClass|null
     */
    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = $this->render_calculator();
        $this->content->footer = '';

        return $this->content;
    }

    /**
     * Render the calculator template.
     *
     * @return string
     */
    private function render_calculator() {
        $renderer = $this->page->get_renderer('block_advanced_calculator');
        $data = new stdClass(); // Any data you want to pass to the template.
        return $renderer->render_calculator($data);
    }

    /**
     * Allow multiple instances of the block.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Where the block can be added.
     *
     * @return array
     */
    public function applicable_formats() {
        return [
            'course-view' => true,
            'mod-quiz' => true,
            'site-index' => true,
            'my' => true,
        ];
    }
}

