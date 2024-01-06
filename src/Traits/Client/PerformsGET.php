<?php

namespace CatalystPay\Traits\Client;

/**
 * Trait for handling HTTP GET requests.
 */
trait PerformsGET
{
    /**
     * Sends an HTTP GET request to the specified URL.
     *
     * @param string $url   The URL to send the request to.
     * @param bool   $isDevelopment  The mode to set if true in production.
     * @param string $token The Authorization token to send the request to.
     *
     * @return array The decoded JSON response.
     *
     * @throws \Exception If an error occurs during the request.
     */
    private static function doGET($url, $isDevelopment, $token)
    {
        // Initialize a new cURL session
        $ch = curl_init();

        // Set the URL to send the request to
        curl_setopt($ch, CURLOPT_URL, $url);

        // Return the response instead of outputting it directly
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set SSL verification based on the mode (true for production, false for testing)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $isDevelopment);

        // Set the Authorization header with the provided token
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token
        ]);

        // Execute the cURL session and store the response
        $response = curl_exec($ch);

        // Check if an error occurred during the request
        if ($response === false) {
            // Throw an exception with the error message
            throw new \Exception('Error: ' . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the JSON response and return it as an associative array
        return json_decode($response, true);
    }
}
