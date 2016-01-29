<?php


namespace Vnphp\PlagiarismChecker\Request;

class Request
{
    /**
     * @var string
     */
    private $id;

    /**
     * Request constructor.
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}