<?php

    require_once 'struct/Test.php';

    require_once 'models/Host.php';
    require_once 'models/VirtualServer.php';
    require_once 'models/WebApplication.php';

    require_once 'helper.php';

    $GLOBALS['debugLevel'] = 0; // Level 0-3

   /*
    * change here the test to see the results on the screen.
    * possible choices: Dynamic || Static
    */
    $test = Test::Dynamic;

    switch ($test) {
        case Test::Dynamic:
            require_once 'tests/runDynamicTest.php';
            break;
        case Test::Static:
            require_once 'tests/runStaticTest.php';
            break;
    }

    //echo 'For all the Applications, we need ' . count($server) . ' servers.';