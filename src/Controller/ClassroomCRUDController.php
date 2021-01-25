<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use App\Service\ClassroomService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/classroom")
 *
 * Class ClassroomCRUDController
 *
 * @package App\Controller
 */
class ClassroomCRUDController extends AbstractController
{
    /**
     * @var ClassroomRepository
     */
    protected ClassroomRepository $classroomRepository;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * @var ClassroomService
     */
    protected ClassroomService $classroomService;

    /**
     * ClassroomCRUDController constructor.
     *
     * @param ClassroomRepository    $classroomRepository
     * @param ClassroomService       $classroomService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ClassroomRepository $classroomRepository,
        ClassroomService $classroomService,
        EntityManagerInterface $entityManager
    )
    {
        $this->classroomRepository = $classroomRepository;
        $this->entityManager = $entityManager;
        $this->classroomService = $classroomService;
    }

    /**
     * @Route("/show/{id}", name="classroom_view", methods="GET")
     *
     * @param Classroom $classroom
     *
     * @return JsonResponse
     */
    public function viewClassroom(Classroom $classroom): JsonResponse
    {
        return $this->json($classroom);
    }

    /**
     * @Route("/show", name="classroom_show", methods="GET")
     *
     * @return JsonResponse
     */
    public function showClassrooms(): JsonResponse
    {
        return $this->json($this->classroomRepository->findAll());
    }

    /**
     * @Route("/creaete", name="classroom_create", methods="POST")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createClassroom(Request $request): JsonResponse
    {
        try {
            $result = $this->classroomService->createClassroom($request->request->all());
            $code = Response::HTTP_CREATED;
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
            $code = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($result, $code);
    }

    /**
     * @Route("/delete/{id}", name="classroom_delete", methods="DELETE")
     *
     * @param Classroom $classroom
     *
     * @return JsonResponse
     */
    public function deleteClassroom(Classroom $classroom): JsonResponse
    {
        $this->entityManager->remove($classroom);
        $this->entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/update/{id}", name="classroom_update", methods="PUT")
     *
     * @param Request   $request
     * @param Classroom $classroom
     *
     * @return JsonResponse
     */
    public function updateClassroom(Request $request, Classroom $classroom): JsonResponse
    {
        try {
            $result = $this->classroomService->updateClassroom($classroom, $request->request->all());
            $code = Response::HTTP_OK;
        } catch (\Exception $exception) {
            $result = $exception->getMessage();
            $code = Response::HTTP_BAD_REQUEST;
        }

        return $this->json($result, $code);
    }
}
