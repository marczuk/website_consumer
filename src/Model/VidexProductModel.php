<?php


namespace App\Model;


class VidexProductModel implements \JsonSerializable
{
    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var int */
    private $price;

    /** @var string */
    private $discount;

    /**
     * Used to sort elements in Descending order
     *
     * @param VidexProductModel $a
     * @param VidexProductModel $b
     * @return bool
     */
    public static function compareByPrice(VidexProductModel $a, VidexProductModel $b)
    {
        return $a->getPrice() < $b->getPrice();
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return VidexProductModel
     */
    public function setTitle(string $title): VidexProductModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return VidexProductModel
     */
    public function setDescription(string $description): VidexProductModel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return VidexProductModel
     */
    public function setPrice(int $price): VidexProductModel
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     * @return VidexProductModel
     */
    public function setDiscount(string $discount): VidexProductModel
    {
        $this->discount = $discount;
        return $this;
    }

}