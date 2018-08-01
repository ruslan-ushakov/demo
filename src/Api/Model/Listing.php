<?php

namespace Api\Model;

use Doctrine\Common\Collections\Criteria;
use Psr\Http\Message\ServerRequestInterface;

class Listing
{
    private const DEFAULT_PAGE_SIZE = 10;

    /**
     * @var int Элементов на странице
     */
    private $pageSize;

    /**
     * @var int Элементов для sql запроса (обычно берем на 1 больше, чтобы узнать есть ли следующая страница)
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var string[]
     */
    private $orderBy;

    public function __construct(int $pageSize, int $offset = 0, array $orderBy = [])
    {
        $this->pageSize = $pageSize;
        $this->offset = $offset;
        $this->orderBy = $orderBy;
    }

    public static function create(ServerRequestInterface $request): self
    {
        $params = $request->getQueryParams();

        $pageSize = $params['limit'] ?? self::DEFAULT_PAGE_SIZE;
        $offset = $params['offset'] ?? 0;
        $orderBy = ['id' => Criteria::ASC];

        if (isset($params['orderBy'])) {
            $direction = $params['orderDirection'] ?? Criteria::ASC;
            $orderBy = [$params['orderBy'] => $direction];
        }

        $self = new self($pageSize, $offset, $orderBy);
        $self->limit = $pageSize + 1; // чтобы узнать есть ли следующая страница без лишнего sql запроса

        return $self;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return \string[]
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }
}
