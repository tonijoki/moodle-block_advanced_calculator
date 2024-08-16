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
 * Advanced calculator renderer.
 *
 * @package    block_advanced_calculator
 * @copyright  2024 Toni Jokinen <toni.o.jokinen@helsinki.fi>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_advanced_calculator_renderer extends plugin_renderer_base {

    /**
     * Render the calculator template.
     *
     * @param stdClass $data Data to pass to the template.
     * @return string HTML output.
     */
    public function render_calculator($data) {
        // Check if the 'number' property is set and is numeric.
        if (isset($data->number) && is_numeric($data->number)) {
            $data->formatted_number = $this->format_number($data->number);
        } else {
            // Handle cases where 'number' is not set or is not numeric.
            $data->formatted_number = 'N/A'; // You can choose an appropriate fallback here.
        }

        return $this->render_from_template('block_advanced_calculator/calculator', $data);
    }

    /**
     * Format a number with spaces every three digits.
     *
     * @param int $number The number to format.
     * @return string The formatted number.
     */
    private function format_number($number) {
        return number_format($number, 0, '.', ' ');
    }
}

