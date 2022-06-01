<?php


    //------------------------- Preparation ------------------------------
    // Server Creation

    $hosts[] = new Host(1, 20, 500, 500);
    $virtualServers = [];
    $webApplications = [];

    for ($i = 0; $i < 12; $i++) {
        $webApplications[] = new WebApplication($i+1, 5, 2, 2);
    }

    //--------------------------------------------------------------------

    $hostId = 0;
    $virtualServerId = 0;
    for ($webAppId = 0; $webAppId < count($webApplications); )
    {
        if (empty($hosts[$hostId]->getVirtualServers())) {
            $hosts[$hostId]->insertVirtualServer(new VirtualServer($virtualServerId + 1, 20, 20, 20));
            $virtualServers = $hosts[$hostId]->getVirtualServers();
            echo '<br><br>--> Virtual Server created -->';
            for (; $virtualServerId < count($virtualServers); ) {

                if ($virtualServers[$virtualServerId]->insertWebApplication($webApplications[$webAppId])) {
                    if ($GLOBALS['debugLevel'] >= 1) echo '<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;App ' . $webApplications[$webAppId]->getId() . ' (CPU: '.$webApplications[$webAppId]->getMaxCpuPower().') inserted into Server ' . $virtualServers[$virtualServerId]->getId() . ' (CPU: '.$virtualServers[$virtualServerId]->getMaxCpuPower() .')<br>';
                    $webAppId++;
                } else {
                    if ($GLOBALS['debugLevel'] >= 3) echo '<br><br> --> next virtual server -->';
                    $virtualServerId++;
                    $hosts[$hostId]->insertVirtualServer(new VirtualServer($virtualServerId + 1, 20, 20, 20));
                    $virtualServers = $hosts[$hostId]->getVirtualServers();
                    echo '<br><br>--> Virtual Server created -->';

                    if ($hosts[$hostId]->insertVirtualServer(new VirtualServer($virtualServerId + 1, 20, 20, 20))) {
                        $virtualServerId++;
                    } else {
                        $hosts[] = new Host($hostId + 1, 20, 500, 500);
                        $hostId++;
                    }
                }

            }
        } else { $virtualServerId++; }

    }

    printServersAndSubsystems($hosts);
/*
    for ($i = 0; $i < count($webApplications); ) {
        if ($virtualServers[$serverIndex]->insertWebApplication($webApplications[$i])) {
            if ($GLOBALS['debugLevel'] >= 1) echo '<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;App ' . $webApplications[$i]->getId() . ' (CPU: '.$webApplications[$i]->getMaxCpuPower().') inserted into Server ' . $virtualServers[$serverIndex]->getId() . ' (CPU: '.$virtualServers[$serverIndex]->getMaxCpuPower() .')<br>';
            $i++;
        } else {
            if ($GLOBALS['debugLevel'] >= 3) echo '<br><br> --> next server -->';
            $serverIndex++;
        }
    }
*/