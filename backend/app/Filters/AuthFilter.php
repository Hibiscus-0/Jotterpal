<?php

namespace App\Filters;

use App\Libraries\TokenService;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine('Authorization');

        if (! preg_match('/^Bearer\s+(.+)$/i', $header, $m)) {
            return $this->deny(401, 'Missing bearer token');
        }

        try {
            $payload = (new TokenService())->decodeAccessToken($m[1]);
        } catch (\Throwable $e){
            return $this->deny(401, 'Invalid or expired token');
        }
        
        if (! empty($arguments) && ! in_array($payload->role, $arguments, true)) {
            return $this->deny(403, 'Insufficient permissions');
        }

        $request->setHeader('X-Auth-User-Id', (string) $payload->sub);
        $request->setHeader('X-Auth-User-Role', (string) $payload->role);
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }

    private function deny(int $status, string $message) 
    {
        return service('response')->setStatusCode($status)->setJSON(['status' => $status, 'error' => $message]);
    }
}
