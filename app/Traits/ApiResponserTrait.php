<?php
namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponserTrait{

    /**
     * susccesResponse
     *
     * @param  string $data
     * @param  int  $code
     * @return Illuminate\Http\JsonResponse
     */
    public function susccesResponse($data, $code = Response::HTTP_OK)
    {
        return response()->json([ 'data' => $data], $code );
    }
        /**
         * errorResponse
         *
         * @param  string $message
         * @param  int $code
         * @return Illuminate\Http\JsonResponse
         */
        public function errorResponse( $message, $code)
    {
        return response()->json(['error' => $message], $code);
    }
}
