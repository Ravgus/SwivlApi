<?php


namespace App\Service;

use App\Entity\Classroom;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class ClassroomService
 */
class ClassroomService
{
    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * ClassroomService constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Classroom $classroom
     * @param array     $data
     *
     * @return Classroom
     * @throws \Exception
     */
    public function updateClassroom(Classroom $classroom, array $data): Classroom
    {
        $classroom->setIsActive($data['isActive'] ?? null);
        $classroom->setName($data['name'] ?? null);

        $this->validate($classroom);

        return $classroom;
    }

    /**
     * @param array $data
     *
     * @return Classroom
     * @throws \Exception
     */
    public function createClassroom(array $data): Classroom
    {
        $classroom = new Classroom();

        return $this->updateClassroom($classroom, $data);
    }

    /**
     * @param $entity
     */
    protected function validate($entity): void
    {
        $violations = $this->validator->validate($entity);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                throw new Exception("'{$violation->getPropertyPath()}' - {$violation->getMessage()}");
            }
        }
    }
}
