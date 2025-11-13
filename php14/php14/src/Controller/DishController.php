<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/dish')]
final class DishController extends AbstractController
{
    #[Route(name: 'app_dish_index', methods: ['GET'])]
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('dish/index.html.twig', [
            'dishes' => $dishRepository->findAll(),
        ]);
    }

    // #[Route('/new', name: 'app_dish_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager,ValidatorInterface $validator): Response
    // {
    //     $dish = new Dish(null,null);
    //     $form = $this->createForm(DishType::class, $dish);
    //     $form->handleRequest($request);

    //     $errors = $validator->validate($dish);

    //     if ($form->isSubmitted() && $form->isValid() && count($errors) === 0) {
    //         $entityManager->persist($dish);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('dish/new.html.twig', [
    //         'dish' => $dish,
    //         'form' => $form,
    //     ]);
    // }

        // #[Route('/{id}', name: 'app_dish_show', methods: ['GET'])]
    // public function show(Dish $dish): Response
    // {
    //     return $this->render('dish/show.html.twig', [
    //         'dish' => $dish,
    //     ]);
    // }


     // #[Route('/{id}/edit', name: 'app_dish_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Dish $dish, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(DishType::class, $dish);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('dish/edit.html.twig', [
    //         'dish' => $dish,
    //         'form' => $form,
    //     ]);
    // }




   #[Route('/new', name: 'app_dish_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        SluggerInterface $slugger
    ): Response
    {
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        $errors = $validator->validate($dish);

        if ($form->isSubmitted() && $form->isValid() && count($errors) === 0) {
            // Обработка загрузки файла
            $uploadedFile = $form->get('imageFile')->getData();
            
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                $projectDir = $this->getParameter('kernel.project_dir');
                try {
                    $uploadedFile->move($projectDir . "/public/uploads/images", $newFilename);
                    $dish->setImagePath("/uploads/images/" . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Ошибка при загрузке файла');
                }
            }

            $entityManager->persist($dish);
            $entityManager->flush();

            return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dish/new.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dish_show', methods: ['GET'])]
    public function show(Dish $dish): Response
    {
        return $this->render('dish/show.html.twig', [
            'dish' => $dish,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dish_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Dish $dish, 
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response
    {
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Обработка загрузки файла
            $uploadedFile = $form->get('imageFile')->getData();
            
            if ($uploadedFile) {
                // Удаляем старый файл если есть
                if ($dish->getImagePath()) {
                    $oldFilePath = $this->getParameter('kernel.project_dir') . '/public' . $dish->getImagePath();
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
                    $dish->setImagePath("/uploads/images/" . $newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Ошибка при загрузке файла');
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dish/edit.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete-image', name: 'app_dish_delete_image', methods: ['POST'])]
    public function deleteImage(Request $request, Dish $dish, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete-image'.$dish->getId(), $request->request->get('_token'))) {
            // Удаляем файл с сервера
            if ($dish->getImagePath()) {
                $filePath = $this->getParameter('kernel.project_dir') . '/public' . $dish->getImagePath();
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            // Удаляем путь из базы
            $dish->setImagePath(null);
            $entityManager->flush();
            
            $this->addFlash('success', 'Изображение успешно удалено');
        }

        return $this->redirectToRoute('app_dish_edit', ['id' => $dish->getId()]);
    }

    #[Route('/{id}/download', name: 'app_dish_download', methods: ['GET'])]
    public function download(Dish $dish): Response
    {
        if (!$dish->getImagePath()) {
            throw $this->createNotFoundException('Файл не найден');
        }

        $filePath = $this->getParameter('kernel.project_dir') . '/public' . $dish->getImagePath();
        
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Файл не найден');
        }

        return $this->file($filePath);
    }


     #[Route('/{id}', name: 'app_dish_delete', methods: ['POST'])]
    public function delete(Request $request, Dish $dish, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dish->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dish);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
    }
}
