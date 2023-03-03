<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ShortenUrlRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;

class ShortenUrlsController extends Controller
{
    const TINY_URL = 'https://tinyurl.com/api-create.php';

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [ 
                "Accept-Encoding" => "application/json", 
                "Content-Type" => "application/json", 
            ], 
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortenUrlRequest $request): JsonResponse
    {
        $tinyUrl = self::TINY_URL . '?url=' . $request->input('url');

        try {
            $request = $this->client->get($tinyUrl);
            $response = $request->getBody()->getContents(); 
        } catch (ClientException $e) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'url' => $response
            ],
            'message' => null
        ]);
    }
}