<?php

require_once './phpTest.php';

NEXT_TEST( "Test #1 add operation" );

TEST_EQ( 5 + 3, 8 );
TEST_EQ( -1 + 4, 3);
TEST_EQ( 2 + 2, 5);

NEXT_TEST( "Test #2 strlen function");

TEST_EQ( strlen('ABCDEF'), 6);
TEST_EQ( strlen(''), 0);

END_TEST();
TESTS_STATS();

?>
