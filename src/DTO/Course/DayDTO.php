<?php

namespace DTO\Course;

use Domain\DateTime\Model\DayOfWeek;

class DayDTO
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $code;

    /**
     * @param string $name
     * @param string $code
     */
    public function __construct(string $name, string $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * @param \Domain\DateTime\Model\DayOfWeek $dayOfWeek
     *
     * @return self
     */
    public static function create(DayOfWeek $dayOfWeek): self
    {
        $code = $dayOfWeek->getCode();
        $dayNames = [
            DayOfWeek::DAY_CODE_MONDAY => 'пн',
            DayOfWeek::DAY_CODE_TUESDAY => 'вт',
            DayOfWeek::DAY_CODE_WEDNESDAY => 'ср',
            DayOfWeek::DAY_CODE_THURSDAY => 'чт',
            DayOfWeek::DAY_CODE_FRIDAY => 'пт',
            DayOfWeek::DAY_CODE_SATURDAY => 'сб',
            DayOfWeek::DAY_CODE_SUNDAY => 'вс',
        ];

        return new self($dayNames[$code], $code);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
