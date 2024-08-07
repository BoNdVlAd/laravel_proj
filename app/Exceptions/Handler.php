<?php
namespace App\Exceptions;

use Exception;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];
    protected $dontReport = [];
    protected $dontFlash = [];





    public function register(): void
    {
        dd(1);
//        dd(1);
//        $this->reportable(function (NotFoundHttpException $e) {
//            return response()->json(['error' => 'Data not found.']);
//        })->stop();

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/users/*')) { // <- Add your condition here
                return response()->json([
                    'message' => 'Vehicle record not found.'
                ], 404);
            }
        });
    }
    public function render($request, Exception|Throwable $e)
    {
        dd(1);
        if ($e instanceof NotFoundHttpException){
            return response('Resource not found', 404);
        }
        return parent::render($request, $e);
    }

}
