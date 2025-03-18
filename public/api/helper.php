<?php

class Helper
{
    public static function getErrorResponse401($detail = '') {
        return Helper::getErrorResponse(401, "Unauthorized", $detail);
    }

    public static function getErrorResponse404($detail = 'API endpoint not found') {
        return Helper::getErrorResponse(404, "Not Found", $detail);
    }

    /**
     * Make a basic RFC 7807 error response
     * 
     * @param int $status The error code (e.g. 404)
     * @param string $title The standard title for errors with this error code
     * @param string $detail Specific information about the error. Empty as a default
     */
    public static function getErrorResponse($status, $title, $detail = '') {
        $errorResponse = [
            'status' => $status,
            'title' => $title,
            // 'detail' => $detail,
        ];

        if ($detail && strlen($detail)) {
            $errorResponse['detail'] = $detail;
        }

        header('Content-Type: application/problem+json');
        http_response_code($status);

        return $errorResponse;
    }
}
