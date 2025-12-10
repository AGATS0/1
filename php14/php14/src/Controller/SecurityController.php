<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\OrderRepository;

class SecurityController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(OrderRepository $orderRepository): Response
    {
        /** @var \App\Entity\Client $client */
        $client = $this->getUser();

        $orders = $orderRepository->findBy(
            ['client' => $client],
            ['id' => 'DESC']
        );

        return $this->render('security/profile.html.twig', [
            'client' => $client,
            'orders' => $orders,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_profile');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastPhone = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_phone' => $lastPhone,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}