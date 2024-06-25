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

/**
 * Calculate the result of a mathematical expression.
 *
 * @param string $expression The mathematical expression to evaluate.
 * @return mixed The result of the expression, or 'Error' if the expression is invalid.
 */
function calculate_expression($expression) {
    // Replace comma with dot for decimal handling.
    $expression = str_replace(',', '.', $expression);

    // Validate expression to avoid security issues.
    if (!preg_match('/^[0-9+\-*/(). ]+$/', $expression)) {
        return 'Error';
    }

    try {
        // Use a safer alternative to eval.
        $result = safe_eval($expression);
        return $result;
    } catch (Exception $e) {
        return 'Error';
    }
}

/**
 * Safely evaluate a mathematical expression.
 *
 * @param string $expression The mathematical expression to evaluate.
 * @return mixed The result of the expression.
 */
function safe_eval($expression) {
    // Tokenize the expression using regex to include numbers and operators.
    $tokens = preg_split('/([+\-*/()])/i', $expression, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

    // Convert infix expression to postfix (RPN).
    $postfix = infix_to_postfix($tokens);

    // Evaluate the postfix expression.
    return evaluate_postfix($postfix);
}

/**
 * Convert an infix expression to postfix (RPN).
 *
 * @param array $tokens The tokenized infix expression.
 * @return array The tokenized postfix expression.
 */
function infix_to_postfix($tokens) {
    $precedence = ['+' => 1, '-' => 1, '*' => 2, '/' => 2];
    $output = [];
    $stack = [];

    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            $output[] = $token;
        } else if (isset($precedence[$token])) {
            while (!empty($stack) && end($stack) != '(' && $precedence[end($stack)] >= $precedence[$token]) {
                $output[] = array_pop($stack);
            }
            $stack[] = $token;
        } else if ($token == '(') {
            $stack[] = $token;
        } else if ($token == ')') {
            while (!empty($stack) && end($stack) != '(') {
                $output[] = array_pop($stack);
            }
            array_pop($stack); // Pop the '('.
        }
    }

    while (!empty($stack)) {
        $output[] = array_pop($stack);
    }

    return $output;
}

/**
 * Evaluate a postfix (RPN) expression.
 *
 * @param array $tokens The tokenized postfix expression.
 * @return mixed The result of the expression.
 */
function evaluate_postfix($tokens) {
    $stack = [];

    foreach ($tokens as $token) {
        if (is_numeric($token)) {
            $stack[] = (float)$token;
        } else {
            $rightoperand = array_pop($stack);
            $leftoperand = array_pop($stack);
            switch ($token) {
                case '+':
                    $stack[] = $leftoperand + $rightoperand;
                    break;
                case '-':
                    $stack[] = $leftoperand - $rightoperand;
                    break;
                case '*':
                    $stack[] = $leftoperand * $rightoperand;
                    break;
                case '/':
                    if ($rightoperand == 0) {
                        throw new Exception('Division by zero');
                    }
                    $stack[] = $leftoperand / $rightoperand;
                    break;
            }
        }
    }

    return array_pop($stack);
}

