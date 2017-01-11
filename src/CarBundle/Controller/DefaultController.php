<?php

namespace CarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class DefaultController extends Controller
{
    /**
     * @Route("/our-cars", name="offer")
     */

    public function indexAction(Request $request)
    {
        // The Car.php contains the Car table
        $carRepository = $this->getDoctrine()->getRepository('CarBundle:Car');
        $cars          = $carRepository->findCarsWithDetails(); // instead of findAll()
        $form          = $this->createFormBuilder()
            ->setMethod('Get')
            ->add('search', TextType::class, ['constraints' => [new NotBlank(), new Length(['min' => 2])] ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            die('Form submitted');
        }

        return $this->render('CarBundle:Default:index.html.twig', ['cars' => $cars, 'form' => $form->createView()]);
    }

    /**
     * @param $id
     * @Route("/car/{id}", name="show_car")
     */
    public function showAction($id)
    {
        $carRepository = $this->getDoctrine()->getRepository('CarBundle:Car');
        $car           = $carRepository->findCarWithDetailsById($id); // instead of find($id)
        return $this->render('CarBundle:Default:show.html.twig', ['car' => $car]);
    }

}
