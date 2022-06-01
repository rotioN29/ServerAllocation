<?php


    // Incremental check depending on Servers capacity
    function addWebApps(array $virtualServers, array $webApplications): array {
        $serverIndex = 0;

        for ($i = 0; $i < count($webApplications); ) {
            if ($virtualServers[$serverIndex]->insertWebApplication($webApplications[$i])) {
                if ($GLOBALS['debugLevel'] >= 1) echo '<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;App ' . $webApplications[$i]->getId() . ' (CPU: '.$webApplications[$i]->getMaxCpuPower().') inserted into Server ' . $virtualServers[$serverIndex]->getId() . ' (CPU: '.$virtualServers[$serverIndex]->getMaxCpuPower() .')<br>';
                $i++;
            } else {
                if ($GLOBALS['debugLevel'] >= 3) echo '<br><br> --> next server -->';
                $serverIndex++;
            }
        }

        return $virtualServers;
    }

	function countVirtualServers($virtualServers): int {
		$counter = 0;
		
		foreach ($virtualServers as $virtualServer) {
			if (!empty($virtualServer->getWebApplications())) {
				$counter++;
			}
		}
		
		return $counter;
	}
	
    function printServersAndSubsystems($hosts): void
    {
        foreach ($hosts as $host) {
            $servers = $host->getVirtualServers();
            echo '<hr>';
            printf('<br>HostID: %s', $host->getId());
            printf(ln(4) . 'CPU: %s', $host->getMaxCpuPower());
            printf(ln(4) . 'RAM: %s', $host->getMaxRamCapacity());
            printf(ln(4) . 'Network: %s', $host->getMaxNetworkBandwidth());
            echo '<br>';

            foreach ($servers as $server) {
                $webApplications = $server->getWebApplications();
                echo '<br>------------------------------------<br>';
                printf(ln(4) . 'VirtualServerID: %s', $server->getId());
                printf(ln(8) . 'CPU: %s', $server->getMaxCpuPower());
                printf(ln(8) . 'RAM: %s', $server->getMaxRamCapacity());
                printf(ln(8) . 'Network: %s', $server->getMaxNetworkBandwidth());
                echo '<br>';
                foreach ($webApplications as $webApplication) {
                    printf(ln(8) . 'Application ID: %s', $webApplication->getId());
                    printf(ln(16) . 'CPU: %s', $webApplication->getMaxCpuPower());
                    printf(ln(16) . 'RAM: %s', $webApplication->getMaxRamCapacity());
                    printf(ln(16) . 'Network: %s', $webApplication->getMaxNetworkBandwidth());
                }
            }
        }
    }

    function printServersAndWebapps($servers): void
    {

        foreach ($servers as $server) {
            $webApplications = $server->getWebApplications();
            echo '<br><br>------------------------------------<br>';
            printf('<br>VirtualServerID: %s', $server->getId());
            printf(ln(2) . 'CPU: %s', $server->getMaxCpuPower());
            printf(ln(2) . 'RAM: %s', $server->getMaxRamCapacity());
            printf(ln(2) . 'Network: %s', $server->getMaxNetworkBandwidth());
            echo '<br>';
            foreach ($webApplications as $webApplication) {
                printf(ln(4) . 'Application ID: %s', $webApplication->getId());
                printf(ln(8) . 'CPU: %s', $webApplication->getMaxCpuPower());
                printf(ln(8) . 'RAM: %s', $webApplication->getMaxRamCapacity());
                printf(ln(8) . 'Network: %s', $webApplication->getMaxNetworkBandwidth());
            }
        }

    }

    /** Line Break and move spaces to the right **/
    function ln($mvr): void {
        echo '<br>';
        for ($space = 0; $space < $mvr; $space++)
            echo '&nbsp;';
    }