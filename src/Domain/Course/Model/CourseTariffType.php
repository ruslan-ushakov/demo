<?php

namespace Domain\Course\Model;

class CourseTariffType
{
    public const CODE_EARLY = 'early';

    public const CODE_REGULAR = 'regular';

    public const CODE_LAST_CHANCE = 'lastChance';

    /**
     * @var string
     */
    private $code;

    /**
     * @param string $code
     */
    public function __construct(string $code)
    {
        if (!in_array($code, $this->getAvailable())) {
            throw new \InvalidArgumentException("Incorrect type code: {$code}");
        }

        $this->code = $code;
    }

    /**
     * @return array
     */
    private function getAvailable()
    {
        return [
            self::CODE_EARLY,
            self::CODE_REGULAR,
            self::CODE_LAST_CHANCE,
        ];
    }

    public static function CODE_EARLY(): self
    {
        return new self(self::CODE_EARLY);
    }

    public static function CODE_REGULAR(): self
    {
        return new self(self::CODE_REGULAR);
    }

    public static function CODE_LAST_CHANCE(): self
    {
        return new self(self::CODE_LAST_CHANCE);
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
