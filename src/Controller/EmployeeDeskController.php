<?php

namespace App\Controller;

use App\Entity\EmployeeDesk;
use App\Form\EmployeeDeskType;
use App\Repository\EmployeeDeskRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/desks")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class EmployeeDeskController extends AbstractController
{
    /**
     * @Route("/", name="employee_desk_index", methods={"GET"})
     * @param EmployeeDeskRepository $employeeDeskRepository
     * @return Response
     */
    public function index(EmployeeDeskRepository $employeeDeskRepository): Response
    {
        return $this->render('employee_desk/index.html.twig', [
            'employee_desks' => $employeeDeskRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="employee_desk_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $employeeDesk = new EmployeeDesk();
        $form = $this->createForm(EmployeeDeskType::class, $employeeDesk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employeeDesk);
            $entityManager->flush();

            return $this->redirectToRoute('employee_desk_index');
        }

        return $this->render('employee_desk/new.html.twig', [
            'employee_desk' => $employeeDesk,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_desk_show", methods={"GET"})
     * @param EmployeeDesk $employeeDesk
     * @return Response
     */
    public function show(EmployeeDesk $employeeDesk): Response
    {
        return $this->render('employee_desk/show.html.twig', [
            'employee_desk' => $employeeDesk,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employee_desk_edit", methods={"GET","POST"})
     * @param Request $request
     * @param EmployeeDesk $employeeDesk
     * @return Response
     */
    public function edit(Request $request, EmployeeDesk $employeeDesk): Response
    {
        $form = $this->createForm(EmployeeDeskType::class, $employeeDesk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_desk_index');
        }

        return $this->render('employee_desk/edit.html.twig', [
            'employee_desk' => $employeeDesk,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_desk_delete", methods={"DELETE"})
     * @param Request $request
     * @param EmployeeDesk $employeeDesk
     * @return Response
     */
    public function delete(Request $request, EmployeeDesk $employeeDesk): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeDesk->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employeeDesk);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_desk_index');
    }
}
