<?php

namespace App\Controller;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Hotel;
use App\Form\RoomNewFormType;
use App\Form\RegisterFormType;
use App\Form\HotelsNewFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FormController extends AbstractController
{

    /*
    # Finir la réponse de retour après la création d'un hotel
    # Faire la gestion des erreurs
    */

    /**
     * @Route("/createHotel", name="createHotel")
     */
    public function createHotel( EntityManagerInterface $em, Request $request )
    {
        $hotel = new Hotel();
        $form = $this->createForm( HotelsNewFormType::class , $hotel );
        $form->handleRequest( $request );

        if( $form->isSubmitted() )
        {
            $hotel->addRooms(json_decode($request->request->get('hotels_new_form')['rooms']));
            $file = $form['img']->getData();

            if( $form->isValid() || count( $hotel->getRooms() ) > 0 )
            {
                if( $file )
                {
                    $originalFileName = pathinfo( $file->getClientOriginalName() , PATHINFO_FILENAME );
                    $safeFileName = transliterator_transliterate( 'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()' , $originalFileName );
                    $newFileName = $safeFileName.'-'.uniqid().'.'.$file->guessExtension();
                    $file->move( $this->getParameter('uploaded_images'), $newFileName );
                    $hotel->setImg( $newFileName );
                    $hotel->setCreatedAt( new \DateTime() );
                    $hotel->setIsActive( false );
                    $em->persist( $hotel );
                    $em->flush();
                }
            }else{
                /**
                 * !gestion des erreurs à faire plus tard.
                 */
            }
            // $response = new Response();
            // //$response->setContent(json_encode( ['url' => $this->generateUrl('homepage') ] ) );
            // $response->headers->set('Content-Type', 'application/json');
            // $response->setStatusCode(Response::HTTP_OK);
            // return $response;
        }
        return $this->render( 'form/hotelNew.html.twig', array('formHotelNew' => $form->createView() ));
    }

    /** 
     * @Route("/createRoom", name="createRoom")
    */
    public function createRoom( EntityManagerInterface $em , Request $request )
    {
        $hotel = new Room();
        $form = $this->createForm( RoomNewFormType::class , $hotel );
        return $this->render( 'form/roomNew.html.twig' , array('formRoomNew' => $form->createView() ) );
    }

    /**
     * @Route("/register", name="register" )
     */
    public function register( EntityManagerInterface $em , Request $request , UserPasswordEncoderInterface $passwordEncoder )
    {
        $user = new User();

        $form = $this->createForm( RegisterFormType::class , $user );
        $form->handleRequest( $request );
        
        if( $form->isSubmitted() )
        {
            if( $form->isValid() )
            {
                $password = $passwordEncoder->encodePassword( $user , $user->getPassword() );
                $user->setPassword( $password );
                //! Faire la gestion des roles.
                $user->setRoles( array() );

                $em->persist( $user );
                $em->flush();
            }
            else
            {
                // !Gestion des erreurs pour l'inscription à effectuer.
            }
            $response = new Response();
            $response->setContent( json_encode( ['url' => $this->generateUrl('homepage') ] ) );
            $response->headers->set( 'Content-Type', 'application/json' );
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        }
        return $this->render( 'form/register.html.twig' , array('formRegister' => $form->createView() ) );
    }

    /**
     * @Route( "/login" , name="login" )
     */
    public function login( Request $request )
    {
        return $this->render( 'form/login.html.twig' );
    }
}
