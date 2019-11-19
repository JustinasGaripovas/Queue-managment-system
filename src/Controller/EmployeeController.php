<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/employees")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="employee_index", methods={"GET"})
     * @param EmployeeRepository $employeeRepository
     * @return Response
     */
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/register", name="employee_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($employee, $employee->getPlainPassword());
            $employee->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_show", methods={"GET"})
     * @param Employee $employee
     * @return Response
     */
    public function show(Employee $employee): Response
    {
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employee_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Employee $employee
     * @return Response
     */
    public function edit(Request $request, Employee $employee): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_delete", methods={"DELETE"})
     * @param Request $request
     * @param Employee $employee
     * @return Response
     */
    public function delete(Request $request, Employee $employee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_index');
    }
}
