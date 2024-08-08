<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class GifController extends Controller
{
    protected string $giphyApiKey;
    protected Client $client;
    protected string $baseGiphyUrl;

    public function __construct()
    {
        $this->giphyApiKey = config('services.giphy.key');
        $this->client = new Client();
        $this->baseGiphyUrl = 'https://api.giphy.com/v1/gifs';
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function showGif(string $id): JsonResponse
    {
        $validator = Validator::make(
            ['id' => $id],
            ['id' => 'required|string']
        );

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        try {
            $response = $this->client->request('GET', "{$this->baseGiphyUrl}/{$id}", [
                'query' => [
                    'api_key' => $this->giphyApiKey,
                ]
            ]);

            $result = json_decode($response->getBody()->getContents());

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch data from GIPHY API'], 500);
        }
    }


    /**
     * @param string $text
     * @param int $limit
     * @param int $offset
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function searchGif(string $text, int $limit = 1, int $offset = 0): JsonResponse
    {
        $validator = Validator::make([
            'text' => $text,
            'limit' => $limit,
            'offset' => $offset
        ], [
            'text' => 'required|max:50',
            'limit' => 'sometimes|required|integer|min:1',
            'offset' => 'sometimes|required|integer|min:0'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        try {
            $response = $this->client->request('GET', "{$this->baseGiphyUrl}/search", [
                'query' => [
                    'api_key' => $this->giphyApiKey,
                    'q' => $text,
                    'limit' => $limit,
                    'offset' => $offset
                ]
            ]);
            $result = json_decode($response->getBody()->getContents());

            return response()->json($result);
        }catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch data from GIPHY API'], 500);
        }

    }
}
