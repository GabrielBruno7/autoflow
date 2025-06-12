<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public const DEFAULT_ERROR_MESSAGE = 'Ocorreu um erro inesperado. Entre em contato com o suporte se o problema persistir';

    use AuthorizesRequests, ValidatesRequests;
}
