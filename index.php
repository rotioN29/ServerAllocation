<?php
    require_once 'require.php';


    /** @var Test $test */
    switch ($test) {
        case Test::Dynamic:
            require_once 'tests/runDynamicTest.php';
            break;
        case Test::Static:
            require_once 'tests/runStaticTest.php';
            break;
    }