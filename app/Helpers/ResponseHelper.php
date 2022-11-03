<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseHelper
{

    private int $code = 200;
    private ?string $message;
    private ?array $data = null;
    private bool $success = true;

    public static function instance()
    {
        return new ResponseHelper;
    }

    public static function success(int $code, array $data = null, string $message = null)
    {
        return self::instance()
            ->setCode($code)
            ->setMessage($message)
            ->setData($data)
            ->setSuccess(true)
            ->json();
    }

    public static function fail(int $code, array $data = null, string $message = null)
    {
        return self::instance()
            ->setCode($code)
            ->setMessage($message)
            ->setData($data)
            ->setSuccess(false)
            ->json();
    }

    public static function notFound()
    {
        return self::instance()
            ->setCode(Response::HTTP_NOT_FOUND)
            ->setMessage(trans('errors.404'))
            ->setSuccess(false)
            ->json();
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function setMessage(?string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function setData(?array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function setSuccess(bool $success)
    {
        $this->success = $success;
        return $this;
    }

    public function json(): JsonResponse
    {

        $response = [];

        if ($this->message !== null)
            $response['message'] = $this->message;

        if ($this->data !== null)
            $response['data'] = $this->data;

        $response['success'] = $this->success;

        return response()->json($response, $this->code);
    }
}
