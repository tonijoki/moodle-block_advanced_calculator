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
     * Get the content of the block.
     *
     * @return stdClass The block content.
     */
    public function get_content() {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();

        // Initialize the data object.
        $data = new stdClass();

        // You would typically fetch or calculate this number based on your application's logic.
        $data->number = 50000; // Example static number, replace with actual logic.

        // Render the calculator with the populated data.
        $renderer = $this->page->get_renderer('block_advanced_calculator');
        $this->content->text = $renderer->render_calculator($data);

        return $this->content;
    }

    /**
     * Define applicable formats for the block.
     *
     * @return array The applicable formats.
     */
    public function applicable_formats() {
        return ['all' => true];
    }
}

