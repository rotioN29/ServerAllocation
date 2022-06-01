<?php

declare(strict_types=1);

require_once 'models/ComputerSpecification.php';
require_once 'models/VirtualServer.php';

class Host extends ComputerSpecification
{
    private array $virtualServers = [];

    public function insertVirtualServer(VirtualServer $newVirtualServer): bool
    {
        if ($GLOBALS['debugLevel'] >= 2) echo '<br>Checking Server ' . $this->getId() . ' | VS CPU: ('.$newVirtualServer->getMaxCpuPower().') | Max Host CPU: ' . $this->maxCpuPower;

        // Limit the first check with the values of the new WebApp
        $currentCpuPower = $newVirtualServer->getMaxCpuPower();
        $currentRamCapacity = $newVirtualServer->getMaxRamCapacity();
        $currentNetworkBandwidth = $newVirtualServer->getMaxNetworkBandwidth();

        // Check if the VirtualServer takes more than the Server itself.
        if ($newVirtualServer->getMaxCpuPower() > $this->maxCpuPower ||
            $newVirtualServer->getMaxRamCapacity() > $this->maxRamCapacity ||
            $newVirtualServer->getMaxNetworkBandwidth() > $this->maxNetworkBandwidth
        ) {
            return false;
        }

        // Check over already inserted WebApps if there is still enough space.
        foreach ($this->virtualServers as $virtualServer) {
            if ($currentCpuPower + $virtualServer->getMaxCpuPower() > $this->maxCpuPower ||
                $currentRamCapacity + $virtualServer->getMaxRamCapacity() > $this->maxRamCapacity ||
                $currentNetworkBandwidth + $virtualServer->getMaxNetworkBandwidth() > $this->maxNetworkBandwidth) {
                if ($GLOBALS['debugLevel'] >= 2) echo '<br>-> No Capacity... ' . $currentCpuPower + $newVirtualServer->getMaxCpuPower() .'>'. $this->maxCpuPower . ' | Continue<br>';

                return false;
            }

            // This needs to be at the bottom otherwise the check results in one missing insertion.
            $currentCpuPower += $virtualServer->getMaxCpuPower();
            $currentRamCapacity += $virtualServer->getMaxRamCapacity();
            $currentNetworkBandwidth += $virtualServer->getMaxNetworkBandwidth();
        }

        $this->virtualServers[] = $newVirtualServer;
        if ($GLOBALS['debugLevel'] >= 3) echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INSERTED';
        return true;
    }

    public function getVirtualServers(): array
    {
        return $this->virtualServers;
    }
}