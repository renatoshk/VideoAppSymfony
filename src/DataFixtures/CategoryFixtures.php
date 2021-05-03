<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $this->loadMainCategories($manager);
      $this->loadSubCategories($manager, 'Animation','1');
    }
    private function loadMainCategories($manager)
    {
        foreach($this->getMainCategoryData() as [$name])
        {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }

        $manager->flush();
    }
    private function getMainCategoryData()
    {
        return [
            ['Animation', 1],
            ['Action', 2],
            ['Comedy', 3],
            ['Drama', 4],
        ];
    }
    private function loadSubCategories($manager, $category, $parent_id)
    {
        $parent = $manager->getRepository(Category::class)->find($parent_id);
        $methodName = "get{$category}Data";
        foreach($this->$methodName() as [$name])
        {
            $category = new Category();
            $category->setName($name);
            $category->setParent($parent);
            $manager->persist($category);
        }

        $manager->flush();

    }
    private function getAnimationData()
    {
        return [
            ['anime', 5],
            ['disney', 6],
        ];
    }
}
