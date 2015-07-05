<?php
namespace Pleo\BSG\Ctrl;

use Slim\View;

class LoginPage
{
    /**
     * @var View
     */
    private $view;

    /**
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function __invoke()
    {
        $this->view->display('home.html');
    }
}
