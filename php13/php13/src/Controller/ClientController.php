<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

final class ClientController extends AbstractController
{
    private $clientRepository;
    private $entityManager;

    public function __construct(ClientRepository $clientRepository, EntityManagerInterface $entityManager)
    {
        $this->clientRepository = $clientRepository;
        $this->entityManager = $entityManager;
    }


    #[Route('/client', name: 'app_client')]
    public function clientsList(EntityManagerInterface $entityManager): Response
    {
         $clientsWithOrders = $entityManager->createQueryBuilder()
            ->select('u.id, u.name, u.email, COUNT(o.id) as ordersCount')
            ->from(Client::class, 'u')
            ->leftJoin('u.orders', 'o')
            ->groupBy('u.id')
            ->orderBy('ordersCount', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('client/list.html.twig', [
            'clients' => $clientsWithOrders,
        ]);

    }

     #[Route('/topclients', name: 'app_client_top')]
    public function clientsTopList(EntityManagerInterface $entityManager): Response
    {
        $topClients = $entityManager->createQueryBuilder()
    // Шаг 1: Выбираем что нам нужно
    ->select('c.name', 'c.email',
             'SUM(oi.quantity * oi.unitPrice) as totalSpent')
    
    // Шаг 2: Указываем откуда берем данные (главная таблица)
    ->from(Client::class, 'c')
    
    // Шаг 3: Присоединяем связанные таблицы
    ->leftJoin('c.orders', 'o')          // заказы клиента
    ->leftJoin('o.orderItems', 'oi')     // товары в заказах
    
    // Шаг 4: Группируем по клиентам (чтобы SUM работал)
    ->groupBy('c.id')
    
    // Шаг 5: Сортируем по убыванию суммы
    ->orderBy('totalSpent', 'DESC')
    
    // Шаг 6: Берем только топ-3
    ->setMaxResults(3)
    
    // Выполняем запрос
    ->getQuery()
    ->getResult();
    

        return $this->render('client/toplist.html.twig', [
            'clients' => $topClients,
        ]);

    }
}
