<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PathaoCourierService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.pathao.base_url');
        $this->clientId = config('services.pathao.client_id');
        $this->clientSecret = config('services.pathao.client_secret');
        $this->username = config('services.pathao.username');
        $this->password = config('services.pathao.password');
    }

    public function getToken()
    {
        return Cache::remember('pathao_access_token', 4320, function () {
            $response = Http::post($this->baseUrl . '/aladdin/api/v1/issue-token', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
            ]);

            if ($response->successful()) {
                return $response['access_token'];
            }

            throw new \Exception('Unable to get Pathao token: ' . $response->body());
        });
    }

    public function createOrder(array $data)
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->post($this->baseUrl . '/aladdin/api/v1/orders', $data);

        return $response->json();
    }

    public function getCities()
    {
        $token = $this->getToken();

        return Http::withToken($token)
            ->get($this->baseUrl . '/aladdin/api/v1/city-list')
            ->json();
    }

    public function getZones($cityId)
    {
        $token = $this->getToken();

        return Http::withToken($token)
            ->get("{$this->baseUrl}/aladdin/api/v1/cities/{$cityId}/zone-list")
            ->json();
    }

    public function getAreas($zoneId)
    {
        $token = $this->getToken();

        return Http::withToken($token)
            ->get("{$this->baseUrl}/aladdin/api/v1/zones/{$zoneId}/area-list")
            ->json();
    }
}
