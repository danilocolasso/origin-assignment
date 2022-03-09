<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidApiKeyException;
use App\Exceptions\MissingApiKeyException;
use Closure;
use Illuminate\Http\Request;

class AccessControlMiddleware
{
    public const API_KEY_HEADER_NAME = 'x-api-key';

    /** @throws MissingApiKeyException|InvalidApiKeyException */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->is('public/*')) {
            return $next($request);
        }

        if (!$request->hasHeader(self::API_KEY_HEADER_NAME)) {
            throw new MissingApiKeyException();
        }

        if (!$this->validateApiKey($request->header(self::API_KEY_HEADER_NAME))) {
            throw new InvalidApiKeyException();
        }

        return $next($request);
    }

    private function validateApiKey(string $apiKey): bool
    {
        return $apiKey === env('API_KEY');
    }
}
