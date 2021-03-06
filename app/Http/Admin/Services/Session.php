<?php

namespace App\Http\Admin\Services;

use App\Services\Auth\Admin as AdminAuth;
use App\Validators\Account as AccountValidator;
use App\Validators\Captcha as CaptchaValidator;

class Session extends Service
{

    /**
     * @var AdminAuth
     */
    protected $auth;

    public function __construct()
    {
        $this->auth = $this->getDI()->get('auth');
    }

    public function login()
    {
        $currentUser = $this->getCurrentUser();

        if ($currentUser->id > 0) {
            $this->response->redirect(['for' => 'home.index']);
        }

        $post = $this->request->getPost();

        $accountValidator = new AccountValidator();

        $user = $accountValidator->checkAdminLogin($post['account'], $post['password']);

        $captchaSettings = $this->getSettings('captcha');

        /**
         * 验证码是一次性的，放到最后检查，减少第三方调用
         */
        if ($captchaSettings['enabled'] == 1) {

            $captchaValidator = new CaptchaValidator();

            $captchaValidator->checkCode($post['ticket'], $post['rand']);
        }

        $this->auth->saveAuthInfo($user);
    }

    public function logout()
    {
        $this->auth->clearAuthInfo();
    }

}
