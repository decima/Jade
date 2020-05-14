<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AttendanceController extends AbstractController
{
    /**
     * @Route("/attendance/{course}", name="attendance")
     */
    public function index(Course $course, EntityManagerInterface $em)
    {
        if (!$course->getIsClosed()) {

            $studentsInList = [];
            foreach ($course->getAttendances() as $attendance) {
                $studentsInList[$attendance->getStudent()->getId()] = $attendance;
            }
            foreach ($course->getPromotion()->getStudents() as $student) {
                if (isset($studentsInList[$student->getId()])) {
                    unset($studentsInList[$student->getId()]);
                } else {
                    $attendance = new Attendance();
                    $attendance->setCourse($course);
                    $attendance->setStudent($student);
                    $em->persist($attendance);
                }
            }
            foreach ($studentsInList as $attendance) {
                $em->remove($attendance);
            }
            $em->flush();
        }
        return $this->render('attendance/index.html.twig', [
            'course' => $course,
        ]);
    }
}
