<?php

declare(strict_types=1);

require_once 'models/ComputerSpecification.php';
require_once 'models/WebApplication.php';

    class VirtualServer extends ComputerSpecification
    {
        private array $webApplications = [];

        public function insertWebApplication(WebApplication $newWebApplication): bool
        {
            if ($GLOBALS['debugLevel'] >= 2) echo '<br>Checking Server ' . $this->getId() . ' | App CPU: ('.$newWebApplication->getMaxCpuPower().') | Max Server CPU: ' . $this->maxCpuPower;

            // Limit the first check with the values of the new WebApp
            $currentCpuPower = $newWebApplication->getMaxCpuPower();
            $currentRamCapacity = $newWebApplication->getMaxRamCapacity();
            $currentNetworkBandwidth = $newWebApplication->getMaxNetworkBandwidth();

            // Check if the WebApplication takes more than the Server itself.
            if ($newWebApplication->getMaxCpuPower() > $this->maxCpuPower ||
                $newWebApplication->getMaxRamCapacity() > $this->maxRamCapacity ||
                $newWebApplication->getMaxNetworkBandwidth() > $this->maxNetworkBandwidth
                ) {
                if ($GLOBALS['debugLevel'] >= 2) echo '<br>&nbsp;&nbsp;App CPU ('.$newWebApplication->getMaxCpuPower().') is bigger than Server ' . $this->id . ' CPU ('.$this->maxCpuPower.')<br>';
                return false;
            }

            // Check over already inserted WebApps if there is still enough space.
            foreach ($this->webApplications as $webApplication) {
                if ($currentCpuPower + $webApplication->getMaxCpuPower() > $this->maxCpuPower ||
                    $currentRamCapacity + $webApplication->getMaxRamCapacity() > $this->maxRamCapacity ||
                    $currentNetworkBandwidth + $webApplication->getMaxNetworkBandwidth() > $this->maxNetworkBandwidth) {
                    if ($GLOBALS['debugLevel'] >= 2) echo '<br>-> No Capacity... ' . $currentCpuPower + $webApplication->getMaxCpuPower() .'>'. $this->maxCpuPower . ' | Continue<br>';

                    return false;
                }

                // This needs to be at the bottom otherwise the check results in one missing insertion.
                $currentCpuPower += $webApplication->getMaxCpuPower();
                $currentRamCapacity += $webApplication->getMaxRamCapacity();
                $currentNetworkBandwidth += $webApplication->getMaxNetworkBandwidth();
            }

            $this->webApplications[] = $newWebApplication;
            if ($GLOBALS['debugLevel'] >= 3) echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INSERTED';
            return true;
        }

        public function getWebApplications(): array
        {
            return $this->webApplications;
        }
    }