<?php
namespace Pleo\BSG\Ctrl;

use Slim\View;
use Symfony\Component\Form\FormBuilderInterface;

class GamesCreatePage
{
    /**
     * @var View
     */
    private $view;
    /**
     * @var FormBuilderInterface
     */
    private $formBuilder;

    /**
     * @param View $view
     * @param FormBuilderInterface $formBuilder
     */
    public function __construct(View $view, FormBuilderInterface $formBuilder)
    {
        $this->view = $view;
        $this->formBuilder = $formBuilder;
    }

    public function __invoke()
    {
        $form = $this->formBuilder
            ->add('game-title', 'text')
            ->add('game-is-pegasus', 'checkbox')
            ->add('game-is-exodus', 'checkbox')
            ->add('game-is-daybreak', 'checkbox')
            ->getForm();

        $this->view->set('form', $form->createView());

        $this->view->display('games-create.html');
    }
}
