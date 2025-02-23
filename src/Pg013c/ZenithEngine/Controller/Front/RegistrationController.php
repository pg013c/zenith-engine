<?php

declare(strict_types=1);

namespace Pg013c\ZenithEngine\Controller\Front;

use Pg013c\ZenithEngine\CommandHandler\UserRegistrationCommandHandler;
use Pg013c\ZenithEngine\Factory\Command\UserRegistrationCommandFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly UserRegistrationCommandFactory $userRegistrationCommandFactory,
        private readonly UserRegistrationCommandHandler $userRegistrationCommandHandler,
    )
    {
    }

    #[Route('/register', name: 'registration_register')]
    public function register(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $userRegistrationCommand = $this->userRegistrationCommandFactory->createFromRequest($request);
            $this->userRegistrationCommandHandler->handle($userRegistrationCommand);
        }

        return $this->render('public/registration/register.html.twig');
    }
}