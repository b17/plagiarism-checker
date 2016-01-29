<?php


namespace Vnphp\PlagiarismChecker\Response;

class Response
{
    /**
     * @var float
     */
    private $uniqueness;

    /**
     * @var Url[]
     */
    private $urls;

    /**
     * Response constructor.
     * @param float $uniqueness
     * @param Url[] $urls
     */
    public function __construct($uniqueness, array $urls)
    {
        $this->uniqueness = $uniqueness;
        $this->urls = $urls;
    }

    /**
     * @return float
     */
    public function getUniqueness()
    {
        return $this->uniqueness;
    }

    /**
     * @return Url[]
     */
    public function getUrls()
    {
        return $this->urls;
    }
}
