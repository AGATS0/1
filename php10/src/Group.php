<?php

namespace Vantyz\Php10;

class Group
{
    public string $groupName;
    public array $students;

    public function __construct(string $groupName, array $students = [])
    {
        $this->groupName = $groupName;
        $this->students = $students;
    }

    public function addStudent(Student $student): void
    {
        $this->students[] = $student;
    }

    public function getGroupAverage(): float
    {
        if (empty($this->students)) {
            return 0;
        }

        $studentsTotalSum = 0;
        $studentsTotalCount = 0;

        foreach ($this->students as $student) {

            $studentAverage = $student->getAverage();
            $studentsTotalSum += $studentAverage;
            $studentsTotalCount++;
        }

        return $studentsTotalSum / $studentsTotalCount;
    }

    public function getBestStudent(): Student
    {
        $maxAverage = 0;
        $totalAverage = 0;
        $bestStudent = NULL;

        foreach ($this->students as $student) {

            $totalAverage = $student->getAverage();
            if ($totalAverage > $maxAverage) {
                $bestStudent = $student;
            }
        }

        return $bestStudent;
    }
}
