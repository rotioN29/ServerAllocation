<?php

    //------------------------- Preparation ------------------------------
    // Server Creation

    $hosts[] = new Host(1, 2000, 8000, 8000);
    $hosts[] = new Host(2, 1500, 8000, 8000);

    $virtualServers[] = new VirtualServer(1, 200, 400, 400);
    $virtualServers[] = new VirtualServer(2, 100, 400, 400);
    $virtualServers[] = new VirtualServer(3, 150, 400, 400);
    $virtualServers[] = new VirtualServer(4, 150, 400, 400);
    $virtualServers[] = new VirtualServer(5, 150, 400, 400);
    $virtualServers[] = new VirtualServer(6, 200, 400, 400);
    $virtualServers[] = new VirtualServer(7, 150, 400, 400);
    $virtualServers[] = new VirtualServer(8, 150, 400, 400);
    $virtualServers[] = new VirtualServer(9, 150, 400, 400);

    $webApplications[] = new WebApplication(1, 100, 2, 2);
    $webApplications[] = new WebApplication(2, 200, 2, 2);
    $webApplications[] = new WebApplication(3, 150, 2, 2);
    $webApplications[] = new WebApplication(4, 50, 2, 2);
    $webApplications[] = new WebApplication(5, 50, 2, 2);
    $webApplications[] = new WebApplication(6, 50, 2, 2);
    $webApplications[] = new WebApplication(7, 1, 2, 2);

    //--------------------------------------------------------------------



    $virtualServers = addWebApps($virtualServers, $webApplications);



    $hostIndex = 0;
    for ($i = 0; $i < count($virtualServers); ) {
        if ($hosts[$hostIndex]->insertVirtualServer($virtualServers[$i])) {
            //if ($GLOBALS['debugLevel'] >= 1) echo '<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;App ' . $webApplications[$i]->getId() . ' (CPU: '.$webApplications[$i]->getMaxCpuPower().') inserted into Server ' . $virtualServers[$serverIndex]->getId() . ' (CPU: '.$virtualServers[$serverIndex]->getMaxCpuPower() .')<br>';
            $i++;
        } else {
            //if ($GLOBALS['debugLevel'] >= 3) echo '<br><br> --> next server -->';
            $hostIndex++;
        }
    }


    printServersAndSubsystems($hosts);
    //printServersAndWebapps($virtualServers);
	
	printf('<br><br>The WebApps requires a total of %s virtual servers.', countVirtualServers($virtualServers));