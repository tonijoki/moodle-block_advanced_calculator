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
 * Functions for advanced calculator block.
 *
 * @package    block_advanced_calculator
 * @copyright  2024 Toni Jokinen <toni.o.jokinen@helsinki.fi>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function calculate_expression($expression) {
    $expression = str_replace(',', '.', $expression);
    try {
        $result = eval("return $expression;");
        return $result;
    } catch (Exception $e) {
        return 'Error';
    }
}

