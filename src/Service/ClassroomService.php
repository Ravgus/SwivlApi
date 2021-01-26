<?php


namespace App\Service;

use App\Entity\Classroom;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Class ClassroomService
 */
class ClassroomService extends BaseService
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
     * @return Classroom|array
     */
    public function updateClassroom(Classroom $classroom, array $data)
    {
        $classroom->setIsActive($data['isActive'] ?? null);
        $classroom->setName($data['name'] ?? null);

        if (!$this->validate($classroom)) {
            return $this->getErrors();
        }

        return $classroom;
    }

    /**
     * @param array $data
     *
     * @return Classroom|array
     */
    public function createClassroom(array $data)
    {
        $classroom = new Classroom();

        return $this->updateClassroom($classroom, $data);
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    protected function validate($entity): bool
    {
        $violations = $this->validator->validate($entity);

        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $this->addError("'{$violation->getPropertyPath()}' - {$violation->getMessage()}");
            }

            return false;
        }

        return true;
    }
}
