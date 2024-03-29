<?php
/*
 * Copyright (C) 2011 by Ivan Galin
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
 
function get_execution_time() {
    static $microtime_start = null;
    if($microtime_start === null)
    {
        $microtime_start = microtime(true);
        return 0.0;
    }
    return microtime(true) - $microtime_start;
}

$test_name = '';
$test_num = 0;
$assert_num = 0;

$total_tests = 0;
$passed_tests = 0;
$failed_tests = 0;

$total_asserts = 0;
$passed_asserts = 0;
$failed_asserts = 0;
$last_passed = 0;
$last_failed = 0;

$break_on_failed = false;

function END_TEST() {
    global $test_num, $test_name, $assert_num,
            $last_passed, $last_failed,
            $passed_asserts, $failed_asserts,
            $passed_tests, $failed_tests;

    echo( "Finished Test {$test_num}: {$test_name} ".
          " Asserts: {$assert_num},".
          " Passed: ".($passed_asserts - $last_passed).",".
          " Failed: ".($failed_asserts - $last_failed)."\n");
    if( $last_failed == $failed_asserts ) $passed_tests++;
    else $failed_tests++;
    $last_passed = $passed_asserts;
    $last_failed = $failed_asserts;
}
function START_TEST( $name ) {
    global $test_num, $test_name, $total_tests, $assert_num;

    $test_num++;
    $total_tests++;
    $assert_num = 0;
    echo( "Start Test {$test_num}: {$name}\n");
    $test_name = $name;
}
function NEXT_TEST( $name ) {
    global $test_num, $assert_num, $test_name;
    global $total_tests, $passed_tests, $failed_test,
            $passed_asserts, $failed_asserts,
            $last_passed, $last_failed;

    if( $test_num != 0 ) {
        END_TEST();
    }
    START_TEST( $name );
}

function TEST_EQ( $a, $b ) {
    global $assert_num, $passed_asserts, $failed_asserts, $total_asserts,
            $break_on_failed, $failed_tests;
    
    $assert_num++;
    $total_asserts++;
    echo( "Assert {$assert_num}: " );
    if( $a === $b ) {
        // PASSED
        $passed_asserts++;
        echo( "PASSED\n" );
    } else {
        // FAILED
        $failed_asserts++;
        echo( "FAILED " );
        echo( "Expected: ".var_export($b, true)." Actual: ".var_export($a, true)."\n");
        if( $break_on_failed ) {
            $failed_tests++;
            TESTS_STATS();
            exit(1);
        }
    }
    
}
function TESTS_STATS() {
    global $assert_num,
           $total_asserts, $passed_asserts, $failed_asserts,
            $total_tests, $passed_tests, $failed_tests;
    echo( "Tests stopped\n");
    echo( "Total tests: {$total_tests}\n" );
    echo( "     Passed: {$passed_tests}\n" );
    echo( "     Failed: {$failed_tests}\n" );
    echo( "Total asserts: {$total_asserts}\n" );
    echo( "       Passed: {$passed_asserts}\n" );
    echo( "       Failed: {$failed_asserts}\n" );
    echo( "\nExecution time: ". get_execution_time() ."\n");
}

get_execution_time();

?>
