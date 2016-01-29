<?php


namespace Vnphp\PlagiarismChecker\Api;

use Vnphp\PlagiarismChecker\Request\Request;
use Vnphp\PlagiarismChecker\Response\Response;

interface ApiInterface
{
    /**
     * @param string $content text to check
     * @param array $excludeDomains domains to exclude
     * @return Request
     */
    public function request($content, array $excludeDomains = []);

    /**
     * @param string $id request id.
     * @return Response
     */
    public function response($id);
}
