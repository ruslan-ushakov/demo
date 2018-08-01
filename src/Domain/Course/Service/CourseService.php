<?php

namespace Domain\Course\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Domain\Course\Model\Course;
use Domain\Course\Model\CoursePerson;
use Domain\Course\Model\CourseTariff;
use Domain\Course\Model\CourseTariffType;
use Domain\Course\Model\CourseType;
use Domain\Course\Model\Schedule;
use Domain\User\Model\User;

class CourseService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $courseTypeId
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     * @param array $lessons
     * @param array $courseTariffs
     * @param \Domain\Course\Model\Schedule $schedule
     *
     * @return \Domain\Course\Model\Course
     */
    public function addCourse(
        $courseTypeId,
        \DateTime $dateStart,
        \DateTime $dateEnd,
        array $lessons = [],
        array $courseTariffs = [],
        Schedule $schedule = null
    ): Course {
        /** @var \Domain\Course\Model\CourseType $courseType */
        $courseType = $this->entityManager->find(CourseType::class, $courseTypeId);

        if (!$courseTariffs) {
            $courseTariffRepository = $this->entityManager->getRepository(CourseTariff::class);
            $courseTariffs = $courseTariffRepository->findAll();
        }

        $course = (new Course())->setCourseType($courseType)
            ->setDateStart($dateStart)
            ->setDateEnd($dateEnd)
            ->setLessons($lessons)
            ->setCourseTariffs($courseTariffs);

        if ($schedule) {
            $course->setSchedule($schedule);
        }

        $this->entityManager->persist($course);
        $this->entityManager->flush($course);

        return $course;
    }

    /**
     * @param string $name
     * @param string $description
     *
     * @return CourseType
     */
    public function addCourseType(string $name, string $description = null): CourseType
    {
        $courseType = (new CourseType())->setName($name)
            ->setDescription($description);

        $this->entityManager->persist($courseType);
        $this->entityManager->flush($courseType);

        return $courseType;
    }

    /**
     * @param int $courseId
     * @param CourseTariffType $type
     * @param string $name
     * @param int $amount
     * @param string $description
     *
     * @return CourseTariff
     */
    public function addCourseTariff(
        int $courseId,
        CourseTariffType $type,
        string $name,
        int $amount,
        string $description
    ): CourseTariff {
        /** @var \Domain\Course\Model\Course $course */
        $course = $this->entityManager->find(Course::class, $courseId);
        $courseTariff = new CourseTariff($type, $name, $amount, $course, $description);

        $this->entityManager->persist($courseTariff);
        $this->entityManager->flush($courseTariff);

        return $courseTariff;
    }

    /**
     * @param int $courseId
     * @param null|string $firstName
     * @param null|string $lastName
     * @param int|null $userId
     *
     * @return CoursePerson
     */
    public function addCoursePerson(
        int $courseId,
        $firstName = null,
        $lastName = null,
        $userId = null
    ): CoursePerson {
        /** @var \Domain\Course\Model\Course $course */
        $course = $this->entityManager->find(Course::class, $courseId);

        /** @var User|null $user */
        $user = null;
        if ($userId) {
            $user = $this->entityManager->find(User::class, $userId);
        }

        $coursePerson = new CoursePerson($course, $firstName, $lastName, $user);

        $this->entityManager->persist($coursePerson);
        $this->entityManager->flush($coursePerson);

        return $coursePerson;
    }
}
