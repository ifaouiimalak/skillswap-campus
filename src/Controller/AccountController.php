<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Form\ProfileFormType;
use App\Repository\BookingRepository;
use App\Repository\MessageRepository;
use App\Security\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/account')]
#[IsGranted('ROLE_USER')]
class AccountController extends AbstractController
{
    #[Route('', name: 'app_account_dashboard')]
    public function dashboard(BookingRepository $bookingRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('account/dashboard.html.twig', [
            'user' => $user,
            'bookings' => $bookingRepository->findBy(['student' => $user], ['createdAt' => 'DESC'], 5),
        ]);
    }

    #[Route('/profile', name: 'app_account_profile')]
    public function profile(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $this->denyAccessUnlessGranted(UserVoter::PROFILE_EDIT, $user);

        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('app_account_profile');
        }

        return $this->render('account/profile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/messages', name: 'app_account_messages')]
    public function messages(
        Request $request,
        MessageRepository $messageRepository,
        EntityManagerInterface $em
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($user);
            $em->persist($message);
            $em->flush();
            $this->addFlash('success', 'Message envoyé.');
            return $this->redirectToRoute('app_account_messages');
        }

        return $this->render('account/messages.html.twig', [
            'messages' => $messageRepository->findForUser($user),
            'form' => $form,
        ]);
    }
}
