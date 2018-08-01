<?php

namespace Api\Model;

/**
 * @SWG\Definition(
 *     definition="Pagination",
 *     type="object",
 *     required={"pageSize", "offset", "hasPrevPage", "hasNextPage", "currentPage"}
 * )
 */
class Pagination implements \JsonSerializable
{
    /**
     * @var array
     */
    private $items;

    /**
     * @var int
     *
     * @SWG\Property(example=10)
     */
    private $pageSize;

    /**
     * @var int
     *
     * @SWG\Property(example=0)
     */
    private $offset;

    /**
     * @var bool
     *
     * @SWG\Property(example=false)
     */
    private $hasPrevPage;

    /**
     * @var bool
     *
     * @SWG\Property(example=true)
     */
    private $hasNextPage;

    /**
     * @var int
     *
     * @SWG\Property(example=1)
     */
    private $currentPage;

    public function __construct(array $items, Listing $listing)
    {
        $this->items = $items;
        $this->pageSize = $listing->getPageSize();
        $this->offset = $listing->getOffset();
        $this->hasPrevPage = $this->offset > 0;
        $this->hasNextPage = count($items) > $this->pageSize;
        $this->currentPage = $this->calcCurrentPage($this->offset, $this->pageSize);
    }

    public function jsonSerialize(): array
    {
        return [
            'limit' => $this->getPageSize(),
            'offset' => $this->getOffset(),
            'hasPrevPage' => $this->isHasPrevPage(),
            'hasNextPage' => $this->isHasNextPage(),
            'currentPage' => $this->getCurrentPage()
        ];
    }

    /**
     * Расчитвает текущую страницу на основе лимит и смещений. Лимит может быть не всегда кратен смещению, например
     * в лимите может быть указан на 1 элемент больше, чтобы узнать есть ли следующая страница в пагинации. Чтобы сгладить
     * эту ситуацию - применяем округление
     *
     * @param int $offset
     * @param int $limit
     *
     * @return int
     */
    private function calcCurrentPage(int $offset, int $limit): int
    {
        return $offset > 0 ? round($offset / $limit) + 1 : 1;
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
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return bool
     */
    public function isHasPrevPage(): bool
    {
        return $this->hasPrevPage;
    }

    /**
     * @return bool
     */
    public function isHasNextPage(): bool
    {
        return $this->hasNextPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPageItems()
    {
        return array_slice($this->items, 0, $this->pageSize);
    }
}
