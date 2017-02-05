<?php

namespace App\Controllers;

use App\Core\Exceptions\RedirectException;
use App\Core\HttpRequest;
use App\Core\Session;

class User extends Controller implements IController
{
    public function indexAction(HttpRequest $request) {
        throw new RedirectException('/');
    }

    public function loginAction(HttpRequest $request)
    {
        $login = $request->getPostVar('login');
        $password = $request->getPostVar('password');

        if (!$login || !$password) {
            throw new RedirectException('/');
        }

        $user = \App\Models\User::getByCondition(['login' => $login]);

        if ($user && $user->validatePassword($password)) {
            Session::getInstance()->set('userId', $user->getId());
        }

        throw new RedirectException('/');
    }

    public function logoutAction()
    {
        Session::getInstance()->set('userId', null);
        session_destroy();
        throw new RedirectException('/');
    }
}