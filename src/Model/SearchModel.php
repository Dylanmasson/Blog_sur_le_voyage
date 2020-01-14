<?php


namespace App\model;


use App\Entity\Category;
use App\Entity\Country;
use phpDocumentor\Reflection\Types\Nullable;

class SearchModel
{
    /**
     * @var Category
     */
    private $category;

    /**
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Country
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;

    }

    /**
     * @var Country
     */
    private $country;
}