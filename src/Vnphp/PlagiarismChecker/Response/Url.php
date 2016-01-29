<?php


namespace Vnphp\PlagiarismChecker\Response;

class Url
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var float
     */
    private $plagiat;

    /**
     * Url constructor.
     * @param string $url
     * @param float $plagiat
     */
    public function __construct($url, $plagiat)
    {
        $this->url = $url;
        $this->plagiat = $plagiat;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return float
     */
    public function getPlagiat()
    {
        return $this->plagiat;
    }
}
