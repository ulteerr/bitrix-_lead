<?php

namespace App\Http\Controllers;

/**
 * Контроллер для работы с главной страницей.
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Возвращает главную страницу
     *
     * @return View
     */

    public function __invoke()
    {
        return view('index');
    }
}
