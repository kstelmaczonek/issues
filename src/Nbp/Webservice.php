<?php

namespace Issue\Nbp;

class Webservice
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param string $from
     * @param string $to
     * @return array
     */
    public function getByDateRange(string $from, string $to): array
    {
        if ($this->validatePeriod($from, $to) === false) {
            throw new \Exception('Period cant be bigger than max configured.');
        }
        $url = sprintf('%1$s%2$s/%3$s', $this->configuration->getUrl(), $from, $to);

        return $this->makeGetRequest($url);
    }

    /**
     * @param array $response
     * @return array
     */
    public function formatResponse(array $response): array
    {
        $format = [];
        foreach ($response as $set) {
           $format[] = [$set['data'] => $set['cena']];
        }

        return $format;
    }

    /**
     * @param string $from
     * @param string $to
     * @return boolean
     */
    private function validatePeriod(string $from, string $to): bool
    {
        $start = new \DateTime($from);
        $start->add(new \DateInterval($this->configuration->getMaxPeriod()));
        $start->setTime(0, 0, 1);

        $end = new \DateTime($to);

        return $end < $start;
    }

    /**
     * @param string $url
     * @return array
     */
    private function makeGetRequest(string $url): array
    {   
        return json_decode(file_get_contents($url), true);
    }
}
