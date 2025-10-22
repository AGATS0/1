<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\OrderRepository;
use App\Repository\ClientRepository;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;


final class OrderController extends AbstractController
{

    public function __construct(
        private OrderRepository $orderRepository,
        private EntityManagerInterface $entityManager,
        private ClientRepository $clientRepository,
        private DishRepository $dishRepository,
    ) {}

    #[Route('/orders', name: 'order_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $orders = $entityManager->getRepository(Order::class)->findAll();

        return $this->render('order/list.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/orders/new', name: 'order_create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,ValidatorInterface $validator): Response
    {
        $order = new Order();
        
        $clients = $this->clientRepository->findAll();
        $dishes =$this->dishRepository->findAll();
        

        if ($request->isMethod('POST')) {
            $clientId = $request->request->get('client');
            $dishIds = $request->request->all('dishes');
            
            $client = $this->clientRepository->find($clientId);
            
            foreach ($dishIds as $dishId) {
                $dish = $this->dishRepository->find($dishId);
                if ($dish) {
                    $order->addDish($dish);
                }
            }

            $order->setClient($client);

            $errors = $validator->validate($order);//empty

           
            
            if (empty($errors)) { //все в этом условии не осуществляется

                $entityManager->persist($order); 
                $entityManager->flush();
                
                
                $this->addFlash('status', 'Заказ успешно создан!');
                
                return $this->redirectToRoute('order_list');

            } else {
                foreach ($errors as $error) {
                    $this->addFlash('error', $error);
                }
            }
        }
        
        return $this->render('order/create.html.twig', [
            'clients' => $clients,
            'dishes' => $dishes,
        ]);
    }


     #[Route('/orders/{id}', name: 'order_show')]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }
}
