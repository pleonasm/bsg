<?php
namespace Pleo\BSG;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Slim;

class Redirector
{
    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $host;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->scheme = $request->getScheme();
        $this->host = $request->getHost();
        $port = $request->getPort();
        $this->response = $response;

        if ('http' === $this->scheme && 80 !== $port) {
            $this->host .= ':' . $port;
        }
        if ('https' === $this->scheme && 443 !== $port) {
            $this->host .= ':' . $port;
        }
    }

    /**
     * @param int $statusCode
     * @param string $urlPath
     */
    public function redirect($statusCode, $urlPath)
    {
        $urlPath = ltrim($urlPath, '/');
        $baseUrl = $this->scheme . '://' . $this->host . '/' . $urlPath;
        $this->response->status($statusCode);
        $this->response->header('Location', $baseUrl);
    }
}
