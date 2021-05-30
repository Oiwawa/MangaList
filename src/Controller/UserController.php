<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route(path="user/", name="user_")
 */
class UserController extends AbstractController
{


    /**
     * @Route(path="{username}", name="edit")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function editProfile(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $entityManager->getRepository('App:User')->findOneBy(['username' => $request->get('username')]);

        if ($request->get('username')=== $this->getUser()->getUsername()){
            $editForm = $this->createForm(EditProfileType::class, $user);
            $editForm->handleRequest($request);
            if ($editForm->isSubmitted() && $editForm->isValid()){
              //  $user->setPassword($passwordEncoder->encodePassword($user, $editForm->get('password')->getData()));
                $entityManager->refresh($user);
                $entityManager->flush();

                $this->addFlash('success', 'Your profile was updated successfuly !');
            }
            return $this->render('user/editProfil.html.twig', [
                'editProfileForm'=>$editForm->createView(),
                'user'=>$user
            ]);
        }

        return $this->render('user/profil.html.twig', ['user'=>$user]);
    }
}