<?php


use Vnphp\PlagiarismChecker\Api\TextRuApi;

class TextRuApiTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Buzz\Browser|\PHPUnit_Framework_MockObject_MockObject
     */
    private $browser;

    /**
     * @var TextRuApi
     */
    private $api;

    protected function setUp()
    {
        $this->browser = $this->getMock('Buzz\Browser');
        $this->api = new TextRuApi($this->browser, '');
    }


    public function testRequest()
    {
        $apiResponse = $this->getResponseMock([
            'text_uid' => 1,
        ]);
        $this->browser->expects($this->once())
            ->method('post')
            ->with("http://api.text.ru/post")
            ->will($this->returnValue($apiResponse));

        $request = $this->api->request('Wow, it works!');
        $this->assertEquals($request->getId(), 1);
    }

    public function testResponse()
    {
        $apiResponse = $this->getResponseMock([
            'result_json' => json_encode([
                'unique' => 80,
                'urls'   => [
                    [
                        'url'     => 'https://google.com.ua',
                        'plagiat' => 100,
                        'words'   => [],
                    ],
                ],
            ]),
        ]);
        $this->browser->expects($this->once())
            ->method('post')
            ->with("http://api.text.ru/post")
            ->will($this->returnValue($apiResponse));

        $response = $this->api->response(1);
        $this->assertEquals(80, $response->getUniqueness());
        $this->assertCount(1, $response->getUrls());

        $url = $response->getUrls()[0];
        $this->assertEquals('https://google.com.ua', $url->getUrl());
        $this->assertEquals(100, $url->getPlagiat());
    }

    /**
     * @expectedException \Vnphp\PlagiarismChecker\Exception\ApiCallException
     */
    public function testException()
    {
        $apiResponse = $this->getResponseMock([
            'error_code' => 142,
            'error_desc' => 'Нехватка баланса',
        ]);
        $this->browser->expects($this->once())
            ->method('post')
            ->with("http://api.text.ru/post")
            ->will($this->returnValue($apiResponse));
        $this->api->request('test');
    }

    /**
     * @param array $rawResponse
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getResponseMock(array $rawResponse)
    {
        $response = $this->getMock('Buzz\Message\MessageInterface');
        $response->expects($this->once())
            ->method("getContent")
            ->will($this->returnValue(json_encode($rawResponse)));

        return $response;
    }
}
