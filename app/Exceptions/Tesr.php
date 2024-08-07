<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Client\Request;

class Tesr extends Exception
{
    /**
     * Render the exception into an HTTP response.
     */
    public function render()
    {
        echo 'some hello';
        exit;
    }
}
