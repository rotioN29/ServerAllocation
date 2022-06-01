<?php

declare(strict_types=1);

abstract class ComputerSpecification 
{
	protected int $id; // Server ID
	protected int $maxCpuPower; // Unit in MHz
	protected int $maxRamCapacity; // Unit in MB (MegaBytes)
	protected int $maxNetworkBandwidth; // Unit in kB (kiloBytes)
	
	public function __construct(int $id, int $maxCpuPower, int $maxRamCapacity, int $maxNetworkBandwidth) {
        $this->id = $id;
        $this->maxCpuPower = $maxCpuPower;
        $this->maxRamCapacity = $maxRamCapacity;
        $this->maxNetworkBandwidth = $maxNetworkBandwidth;
    }
		
    public function getId(): int {
        return $this->id;
    }

    public function getMaxCpuPower() : int {
        return $this->maxCpuPower;
    }

    public function getMaxRamCapacity() : int {
        return $this->maxRamCapacity;
    }

    public function getMaxNetworkBandwidth() : int {
        return $this->maxNetworkBandwidth;
    }
}