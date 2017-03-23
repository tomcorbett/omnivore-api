<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\Category;

class Menu extends AbstractResource
{
    const RESOURCE_URL = 'menu/';

    public $categories = [];

    public function getCategories()
    {
        if (!empty($categories)) {
            return $this->categories;
        }

        $response = $this->client->get($this->getUrl().Category::RESOURCE_URL)->getData();

        if (!empty($response['categories'])) {

            foreach ($response['categories'] as $category) {
                $this->categories[] = new Category($this->locationId, $category['id'], $category['name']);
            }
        }

        return $this->categories;
    }

    public function getMenuItems()
    {

    }

    public function setCategories($categories)
    {
        if (!empty($categories)) {

            foreach ($categories as $category) {

            }
        }
    }
}
