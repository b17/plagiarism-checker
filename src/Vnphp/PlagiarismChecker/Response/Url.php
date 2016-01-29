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
     * @var array
     */
    private $words;

    /**
     * Url constructor.
     * @param string $url
     * @param float $plagiat
     * @param array $words
     */
    public function __construct($url, $plagiat, array $words = [])
    {
        $this->url = $url;
        $this->plagiat = $plagiat;
        $this->words = $words;
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

    /**
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }


}
