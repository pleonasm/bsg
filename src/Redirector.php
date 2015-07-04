<?php
namespace Pleo\BSG;

use Slim\Slim;

class Redirector
{
    private $scheme;
    private $host;
    private $response;

    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {
        $this->scheme = $slim->request()->getScheme();
        $this->host = $slim->request()->getHost();
        $port = $slim->request()->getPort();
        $this->response = $slim->response();

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
    public function __invoke($statusCode, $urlPath)
    {
        $urlPath = ltrim($urlPath, '/');
        $baseUrl = $this->scheme . '://' . $this->host . '/' . $urlPath;
        $this->response->status($statusCode);
        $this->response->header('Location', $baseUrl);
    }
}
