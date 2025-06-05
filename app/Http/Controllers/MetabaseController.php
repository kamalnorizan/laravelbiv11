<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class MetabaseController extends Controller
{
    public function getEmbedUrl($type = 'dashboard', $id) {
        $METABASE_SITE_URL = env('METABASE_SITE_URL');
        $METABASE_SECRET_KEY = env('METABASE_SECRET_KEY');
        $params = (object) [];
        $id = (int) $id;

        $payload = [
            'resource' => [
                $type=> $id,
            ],
            'params' => $params,
            'exp' => time() + 3600, // Token expiration time (1 hour)
        ];

        $token = JWT::encode($payload, $METABASE_SECRET_KEY, 'HS256');
        $embedUrl = $METABASE_SITE_URL . '/embed/'.$type.'/' . $token . '#bordered=true&titled=true';

        return response()->json([
            'embedUrl' => $embedUrl,
        ]);
    }
}
