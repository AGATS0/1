<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\ClientRepository;
use App\Repository\DishRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/order')]
final class OrderController extends AbstractController
{

    public function __construct(
        private OrderRepository $orderRepository,
        private EntityManagerInterface $entityManager,
        private ClientRepository $clientRepository,
        private DishRepository $dishRepository,
    ) {}


    #[Route(name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/list.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator,SluggerInterface $slugger): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        $errors = $validator->validate($order);

        if ($form->isSubmitted() && $form->isValid() && count($errors) === 0) {

            $uploadedFile = $form->get('file')->getData();

             if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                $projectDir = $this->getParameter('kernel.project_dir');
                try {
                    $uploadedFile->move($projectDir . "/public/uploads/orders", $newFilename);
                    $order->setFilePath("/uploads/orders/" . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Ошибка при загрузке файла');
                }
            }

            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_order_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('file')->getData();

            if ($uploadedFile) {
                if ($order->getFilePath()) {
                    $oldFilePath = $this->getParameter('kernel.project_dir') . '/public' . $order->getFilePath();
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                $projectDir = $this->getParameter('kernel.project_dir');
                try {
                    $uploadedFile->move($projectDir . "/public/uploads/images", $newFilename);
                    $order->setFilePath("/uploads/orders/" . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Ошибка при загрузке файла');
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete-file', name: 'app_order_delete_file', methods: ['POST'])]
    public function deleteFile(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete-file'.$order->getId(), $request->request->get('_token'))) {

            if ($order->getFilePath()) {
                $filePath = $this->getParameter('kernel.project_dir') . '/public' . $order->getFilePath();
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Удаляем путь из базы
            $order->setFilePath(null);
            $entityManager->flush();
            
            $this->addFlash('success', 'Файл успешно удален');
        }

        return $this->redirectToRoute('app_order_edit', ['id' => $order->getId()]);
    }

     #[Route('/{id}/download', name: 'app_order_download', methods: ['GET'])]
    public function download(Order $order): Response
    {
        if (!$order->getFilePath()) {
            throw $this->createNotFoundException('Файл не найден');
        }

        $filePath = $this->getParameter('kernel.project_dir') . '/public' . $order->getFilePath();
        
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Файл не найден');
        }

        return $this->file($filePath);
    }


    #[Route('/{id}', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
