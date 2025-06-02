<?php

        namespace App\Http\Middleware;

        use App\Models\ApiKey;
        use Closure;
        use Illuminate\Http\Request;
        use Symfony\Component\HttpFoundation\Response;

        class ApiKeyMiddleware
        {
            /**
             * Handle an incoming request.
             */
            public function handle(Request $request, Closure $next): Response
            {
                $apiKey = $request->header('x-api-key');

                if (!$apiKey) {
                    return response()->json(['error' => 'Clé API manquante'], 401);
                }

                $apiKeyModel = ApiKey::where('key', $apiKey)->first();

                if (!$apiKeyModel) {
                    return response()->json(['error' => 'Clé API invalide'], 401);
                }

                $request->merge(['user_from_api_key' => $apiKeyModel->user]);

                return $next($request);
            }
        }
