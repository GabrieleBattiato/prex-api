<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeUserFavoriteGif(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'gif_id' => 'required|string',
            'alias' => 'required|max:50'
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        try {
            $user = auth()->user();

            $user->setFavoriteGif($request->gif_id, $request->alias);

            return response()->json(['message' => 'Favorite GIF saved successfully'], 201);
        }catch (\Exception $e){
            return response()->json(['error' => 'Unable to fetch data from GIPHY API'], 500);
        }

    }

}
