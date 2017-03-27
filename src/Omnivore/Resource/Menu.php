<?php
namespace Omnivore\Resource;

use Omnivore\Resource\AbstractResource;
use Omnivore\Resource\Category;
use Omnivore\DataObject;

class Menu extends AbstractResource
{
    const RESOURCE_URL = 'menu';

    public $categories  = [];
    public $menuItems   = [];

    public function getCategories()
    {
        if (!empty($this->categories)) {
            return $this->categories;
        }

        $categories = $this->get($this->getUrl().'/'.Category::RESOURCE_URL)->getEmbeddedDataByKey('categories');

        if (!is_null($categories)) {

            foreach ($categories as $category) {
                $this->categories[$category['id']] = new Category($this->locationId, new DataObject($category));
            }
        }

        return $this->categories;
    }

    public function getMenuItems()
    {
        if (!empty($this->menuItems)) {
            return $this->menuItems;
        }

        $response   = $this->get($this->getUrl().'/'.MenuItem::RESOURCE_URL);
        $menuItems  = $response->getEmbeddedDataByKey('menu_items');

        if (!is_null($menuItems)) {
            foreach ($menuItems as $menuItem) {
                $this->menuItems[$menuItem['id']] = new MenuItem($this->locationId, new DataObject($menuItem));
            }
        }

        return $this->menuItems;
    }

    public function getMenuItem($menuItemId)
    {
        if (isset($this->menuItems[$menuItemId]) && !empty($this->menuItems[$menuItemId])) {
            return $this->menuItems[$menuItemId];
        }

        $menuItemData = $this->client->get($this->getUrl().'/'.MenuItem::RESOURCE_URL."/{$menuItemId}/")->getData();
        $this->menuItems[$menuItemId] = new MenuItem($this->locationId, new DataObject($menuItemData));

        return $this->menuItems[$menuItemId];
    }
}
