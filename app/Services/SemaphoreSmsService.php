<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SemaphoreSmsService
{
    public function send(string $toPhoneNumber, string $message): bool
    {
        // Use the provided API key directly
        $apiKey = '3ebff80a660b6fdc30f8649c21110f7c';
        
        // Use MatnogTRSM as primary sender name
        $senderName = 'MatnogTRSM';
        Log::info('Sender name set to: ' . $senderName);

        if (!$apiKey) {
            Log::error('Semaphore API key is not configured.');
            return false;
        }

        try {
            // Normalize PH numbers: 09XXXXXXXXX -> 639XXXXXXXXX, +639 -> 639
            $normalized = preg_replace('/\D+/', '', $toPhoneNumber);
            if (str_starts_with($normalized, '09') && strlen($normalized) === 11) {
                $normalized = '63' . substr($normalized, 1);
            } elseif (str_starts_with($normalized, '639') && strlen($normalized) === 12) {
                // already correct
            } elseif (str_starts_with($normalized, '9') && strlen($normalized) === 10) {
                $normalized = '63' . $normalized;
            } elseif (str_starts_with($normalized, '63') === false && strlen($normalized) >= 10) {
                // Last resort: assume PH, prepend 63
                $normalized = '63' . ltrim($normalized, '0');
            }

            // Semaphore v4 expects 'number' (single) not 'numbers'
            $payload = [
                'apikey' => $apiKey,
                'number' => $normalized,
                'message' => $message,
                'sendername' => 'MatnogTRSM',
            ];
            
            Log::info('Semaphore SMS attempt with MatnogTRSM', [
                'raw_to' => $toPhoneNumber,
                'normalized_to' => $normalized,
                'sendername' => 'MatnogTRSM',
            ]);

            // Primary attempt with 'number'
            $response = Http::timeout(30)->asForm()->post('https://api.semaphore.co/api/v4/messages', $payload);

            // Treat JSON validation responses as failures even if HTTP 200
            if ($response->successful()) {
                $responseData = $response->json();
                $body = $response->body();
                $hasValidationError = false;
                if (is_array($responseData)) {
                    // Common validation shape: { "number": ["The number field is required."] }
                    if (isset($responseData['number']) && is_array($responseData['number'])) {
                        $hasValidationError = true;
                    }
                    if (isset($responseData['error']) || isset($responseData['errors'])) {
                        $hasValidationError = true;
                    }
                }
                if (!$hasValidationError) {
                    Log::info('Semaphore SMS request accepted', [
                        'to' => $normalized,
                        'sendername' => 'MatnogTRSM',
                        'response_body' => $body,
                        'response_data' => $responseData,
                    ]);
                    return true;
                }
                // fall-through to retry logic below
            }

            // Check if it's a sender name error
            $responseBody = $response->body();
            if (strpos($responseBody, 'senderName') !== false && strpos($responseBody, 'not valid') !== false) {
                Log::warning('MatnogTRSM sender name not approved yet, trying without sender name', [
                    'status' => $response->status(),
                    'body' => $responseBody,
                ]);
                
                // Remove sender name and try again
                unset($payload['sendername']);
                $response2 = Http::timeout(30)->asForm()->post('https://api.semaphore.co/api/v4/messages', $payload);
                
                if ($response2->successful()) {
                    $responseData2 = $response2->json();
                    Log::info('Semaphore SMS sent successfully without sender name (MatnogTRSM pending approval)', [
                        'to' => $normalized,
                        'method' => 'number_param_no_sender',
                        'response_body' => $response2->body(),
                        'response_data' => $responseData2,
                        'message_id' => $responseData2[0]['messageId'] ?? 'unknown',
                        'status' => $responseData2[0]['status'] ?? 'unknown',
                    ]);
                    return true;
                }
                
                // Final fallback already uses 'number'; just log the failure
                $response3 = $response2;
                
                if ($response3->successful()) {
                    $responseData3 = $response3->json();
                    Log::info('Semaphore SMS sent successfully without sender name (MatnogTRSM pending approval)', [
                        'to' => $normalized,
                        'method' => 'number_param_no_sender_dup',
                        'response_body' => $response3->body(),
                        'response_data' => $responseData3,
                        'message_id' => $responseData3[0]['messageId'] ?? 'unknown',
                        'status' => $responseData3[0]['status'] ?? 'unknown',
                    ]);
                    return true;
                }
            }

            Log::error('Semaphore SMS failed', [
                'first_status' => $response->status(),
                'first_body' => $response->body(),
                // secondary attempts may not have been issued
            ]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Semaphore SMS exception: ' . $e->getMessage());
            return false;
        }
    }

    public function checkAccountStatus(): array
    {
        $apiKey = '3ebff80a660b6fdc30f8649c21110f7c';
        
        try {
            // Check account info
            $accountResponse = Http::timeout(30)->get('https://api.semaphore.co/api/v4/account', [
                'apikey' => $apiKey
            ]);
            
            // Check sender names
            $sendersResponse = Http::timeout(30)->get('https://api.semaphore.co/api/v4/senders', [
                'apikey' => $apiKey
            ]);
            
            Log::info('Semaphore Account Status Check', [
                'account_status' => $accountResponse->status(),
                'account_data' => $accountResponse->json(),
                'senders_status' => $sendersResponse->status(),
                'senders_data' => $sendersResponse->json(),
            ]);
            
            return [
                'account' => $accountResponse->json(),
                'senders' => $sendersResponse->json(),
                'account_status_code' => $accountResponse->status(),
                'senders_status_code' => $sendersResponse->status(),
            ];
        } catch (\Throwable $e) {
            Log::error('Semaphore Account Status Check Failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}


