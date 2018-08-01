<?php

namespace DTO\Course;

use Domain\Course\Model\EventBooking;

class EventBookingDTO
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $personName;

    /**
     * @var string
     */
    private $personLastName;

    /**
     * @var string
     */
    private $personEmail;

    /**
     * @var string
     */
    private $personPhone;

    /**
     * @var string|null
     */
    private $comment;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @param int $id
     * @param string $personName
     * @param string $personLastName
     * @param string $personEmail
     * @param string $personPhone
     * @param null|string $comment
     * @param \DateTime $createdAt
     */
    public function __construct(
        $id,
        $personName,
        $personLastName,
        $personEmail,
        $personPhone,
        \DateTime $createdAt,
        ?string $comment = null
    ) {
        $this->id = $id;
        $this->personName = $personName;
        $this->personLastName = $personLastName;
        $this->personEmail = $personEmail;
        $this->personPhone = $personPhone;
        $this->comment = $comment;
        $this->createdAt = $createdAt;
    }

    public static function create(EventBooking $eventBooking): self
    {
        return new self(
            $eventBooking->getId(),
            $eventBooking->getPerson()->getName(),
            $eventBooking->getPerson()->getLastName(),
            $eventBooking->getPerson()->getEmail(),
            $eventBooking->getPerson()->getPhone(),
            $eventBooking->getCreatedAt(),
            $eventBooking->getComment()
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPersonName(): string
    {
        return $this->personName;
    }

    /**
     * @return string
     */
    public function getPersonLastName(): string
    {
        return $this->personLastName;
    }

    /**
     * @return string
     */
    public function getPersonEmail(): string
    {
        return $this->personEmail;
    }

    /**
     * @return string
     */
    public function getPersonPhone(): string
    {
        return $this->personPhone;
    }

    /**
     * @return null|string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
