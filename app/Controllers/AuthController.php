<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Entity\User;
use Slim\Views\Twig;
use Valitron\Validator;
use Doctrine\ORM\EntityManager;
use App\Exception\ValidationException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function __construct(private readonly Twig $twig, private readonly EntityManager $entityManager)
    {
    }

    public function loginView(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'auth/login.twig');
    }

    public function registerView(Request $request, Response $response): Response
    {
        return $this->twig->render($response, 'auth/register.twig');
    }

    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $v = new Validator($data);

        $v->rule('required', ['name', 'email', 'password', 'comfirmPassword']);
        $v->rule('email', 'email');
        $v->rule('equals', 'comfirmPassword', 'password')->label('Confirm Password');
        $v->rule(fn($field, $value, $params, $fields) => ! $this->entityManager->getRepository(User::class)->count(['email' => $value]), 'email')
            ->message('User with this email already exists');

        if (! $v->validate()) {
            throw new ValidationException($v->errors());
        }

        $user = new User();

        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $response;
    }
}
