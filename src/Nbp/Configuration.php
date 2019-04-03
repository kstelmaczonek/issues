<?php

namespace Issue\Nbp;

final class Configuration 
{
    private $url = 'http://api.nbp.pl/api/cenyzlota/';
    /** Setting 1 year period due API limitations */
    private $maxPeriod = 'P1Y';

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getMaxPeriod(): string
    {
        return $this->maxPeriod;
    }
}