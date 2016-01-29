<?php


namespace Vnphp\PlagiarismChecker\Api;

use Buzz\Browser;
use Vnphp\PlagiarismChecker\Exception\ApiCallException;
use Vnphp\PlagiarismChecker\Request\Request;
use Vnphp\PlagiarismChecker\Response\Response;
use Vnphp\PlagiarismChecker\Response\Url;

class TextRuApi implements ApiInterface
{
    /**
     * @var Browser
     */
    private $browser;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiUrl = 'http://api.text.ru/post';

    /**
     * TextRuApi constructor.
     * @param Browser $browser
     * @param string $apiKey
     */
    public function __construct(Browser $browser, $apiKey)
    {
        $this->browser = $browser;
        $this->apiKey = $apiKey;
    }

    /**
     * @inheritdoc
     */
    public function response($id)
    {
        $args = [
            'uid' => $id,
        ];

        $data = json_decode($this->call($args)['result_json'], true);

        $urls = array_map(function ($url) {
            return new Url($url['url'], $url['plagiat']);
        }, $data['urls']);

        $response = new Response($data['unique'], $urls);
        return $response;
    }

    public function call(array $args)
    {
        $args['userkey'] = $this->apiKey;
        $response = $this->browser->post($this->apiUrl, [], $args);
        $data = json_decode($response->getContent(), true);
        if (isset($data['error_code'])) {
            throw new ApiCallException($data['error_desc'], $data['error_code']);
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function request($content, array $excludeDomains = [])
    {
        $args = [
            'text'         => $content,
            'exceptdomain' => join(',', $excludeDomains),
        ];

        $rawResponse = $this->call($args);
        $request = new Request($rawResponse['text_uid']);

        return $request;
    }
}
