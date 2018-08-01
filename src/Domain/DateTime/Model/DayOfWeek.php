<?php

namespace Domain\DateTime\Model;

class DayOfWeek
{
    const DAY_MONDAY = 1;

    const DAY_TUESDAY = 2;

    const DAY_WEDNESDAY = 3;

    const DAY_THURSDAY = 4;

    const DAY_FRIDAY = 5;

    const DAY_SATURDAY = 6;

    const DAY_SUNDAY = 7;

    const DAY_CODE_MONDAY = 'mon';

    const DAY_CODE_TUESDAY = 'tue';

    const DAY_CODE_WEDNESDAY = 'wed';

    const DAY_CODE_THURSDAY = 'thu';

    const DAY_CODE_FRIDAY = 'fri';

    const DAY_CODE_SATURDAY = 'sat';

    const DAY_CODE_SUNDAY = 'sun';

    private const DAY_TO_CODE = [
        self::DAY_MONDAY => self::DAY_CODE_MONDAY,
        self::DAY_TUESDAY => self::DAY_CODE_TUESDAY,
        self::DAY_WEDNESDAY => self::DAY_CODE_WEDNESDAY,
        self::DAY_THURSDAY => self::DAY_CODE_THURSDAY,
        self::DAY_FRIDAY => self::DAY_CODE_FRIDAY,
        self::DAY_SATURDAY => self::DAY_CODE_SATURDAY,
        self::DAY_SUNDAY => self::DAY_CODE_SUNDAY,
    ];

    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        if (!(self::DAY_MONDAY <= $value && $value <= self::DAY_SUNDAY)) {
            throw new \InvalidArgumentException("The day of the week should be from 1 to 7");
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCode(): string
    {
        return self::DAY_TO_CODE[$this->value];
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }
}
