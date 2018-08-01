<?php

namespace Domain\DateTime\Model;

class Time
{
    /**
     * @var int
     */
    private $hour;

    /**
     * @var int
     */
    private $minute;

    /**
     * @var int
     */
    private $second;

    /**
     * Time constructor.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     */
    public function __construct(int $hour, int $minute, int $second = 0)
    {
        $this->assertHourIsCorrect($hour);
        $this->assertTimeValueIsCorrect($minute);
        $this->assertTimeValueIsCorrect($second);

        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    public static function createFromString(string $time): self
    {
        $time = explode(':', $time);
        $hour = $time[0] ?? 0;
        $minute = $time[1] ?? 0;
        $second = $time[2] ?? 0;

        return new self($hour, $minute, $second);
    }

    public static function createFromDateTime(\DateTime $dateTime): self
    {
        return new self(
            $dateTime->format('H'),
            $dateTime->format('i'),
            $dateTime->format('s')
        );
    }

    /**
     * @return int
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * @return int
     */
    public function getSecond(): int
    {
        return $this->second;
    }

    /**
     * Возвращает время в формате 01:05:00
     *
     * @return string
     */
    public function getValue(): string
    {
        return sprintf('%01d:%02d:%02d', $this->hour, $this->minute, $this->second);
    }

    /**
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return new \DateTime($this->getValue());
    }

    public function __toString()
    {
        return $this->getValue();
    }

    private function assertHourIsCorrect(int $hour)
    {
        if (!(0 <= $hour && $hour <= 23)) {
            throw new \LogicException("The hour must be between 0 and 23. Received: {$hour}");
        }
    }

    private function assertTimeValueIsCorrect(int $timeValue)
    {
        if (!(0 <= $timeValue && $timeValue <= 59)) {
            throw new \LogicException("The time value must be between 0 and 59. Received: {$timeValue}");
        }
    }
}
