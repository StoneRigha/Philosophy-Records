<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class FirebaseTokenVerifier
{
    private const FIREBASE_CERTS_URL = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';

    public function verifyIdToken(string $idToken): array
    {
        [$header, $payload, $signature] = $this->splitJwt($idToken);

        $keyId = $header['kid'] ?? null;
        if (! $keyId) {
            throw new RuntimeException('Invalid Firebase token header.');
        }

        $publicKeys = $this->getFirebasePublicKeys();
        $publicKey = $publicKeys[$keyId] ?? null;
        if (! $publicKey) {
            throw new RuntimeException('Unable to find Firebase public key for token.');
        }

        if (! $this->verifySignature($idToken, $publicKey)) {
            throw new RuntimeException('Firebase token signature is invalid.');
        }

        $projectId = config('services.firebase.project_id') ?: env('FIREBASE_PROJECT_ID');
        if (! $projectId) {
            throw new RuntimeException('FIREBASE_PROJECT_ID is not configured.');
        }

        $this->validateClaims($payload, $projectId);

        return $payload;
    }

    private function splitJwt(string $jwt): array
    {
        $parts = explode('.', $jwt);

        if (count($parts) !== 3) {
            throw new RuntimeException('Invalid Firebase token format.');
        }

        return [
            $this->jsonDecode($this->base64UrlDecode($parts[0])),
            $this->jsonDecode($this->base64UrlDecode($parts[1])),
            $this->base64UrlDecode($parts[2]),
        ];
    }

    private function base64UrlDecode(string $value): string
    {
        $remainder = strlen($value) % 4;
        if ($remainder) {
            $value .= str_repeat('=', 4 - $remainder);
        }

        return base64_decode(strtr($value, '-_', '+/'));
    }

    private function jsonDecode(string $value): array
    {
        $decoded = json_decode($value, true);
        if (! is_array($decoded)) {
            throw new RuntimeException('Unable to decode Firebase token JSON.');
        }

        return $decoded;
    }

    private function getFirebasePublicKeys(): array
    {
        return Cache::remember('firebase_public_keys', 60 * 60 * 24, function () {
            $response = Http::get(self::FIREBASE_CERTS_URL);

            if (! $response->successful()) {
                throw new RuntimeException('Unable to fetch Firebase public keys.');
            }

            return $response->json();
        });
    }

    private function verifySignature(string $jwt, string $publicKey): bool
    {
        $parts = explode('.', $jwt);
        $signedData = $parts[0] . '.' . $parts[1];
        $signature = $this->base64UrlDecode($parts[2]);

        $publicKey = "-----BEGIN CERTIFICATE-----\n" . wordwrap($publicKey, 64, "\n", true) . "\n-----END CERTIFICATE-----\n";

        return openssl_verify($signedData, $signature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
    }

    private function validateClaims(array $claims, string $projectId): void
    {
        $issuer = 'https://securetoken.google.com/' . $projectId;

        if (($claims['aud'] ?? '') !== $projectId || ($claims['iss'] ?? '') !== $issuer) {
            throw new RuntimeException('Firebase token audience or issuer is invalid.');
        }

        if (empty($claims['sub']) || strlen($claims['sub']) > 128) {
            throw new RuntimeException('Firebase token subject is invalid.');
        }

        $now = time();
        if (($claims['iat'] ?? 0) > $now || ($claims['exp'] ?? 0) < $now) {
            throw new RuntimeException('Firebase token is expired or not yet valid.');
        }

        if (empty($claims['email']) || empty($claims['email_verified'])) {
            throw new RuntimeException('Firebase token must contain a verified email.');
        }
    }
}
