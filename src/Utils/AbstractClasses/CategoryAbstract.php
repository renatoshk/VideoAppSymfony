<?php


namespace App\Utils\AbstractClasses;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryAbstract
{
    public $categoriesFromDb;
    public $treeCategoryHtml;
    protected static $dbconnection;
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
      $this->entityManager = $entityManager;
      $this->urlGenerator  = $urlGenerator;
      $this->categoriesFromDb = $this->getCategories();
    }
    abstract public function getCategoryList(array $categories_array);
    public function buildTree(int $parent_id = null):array
    {
        $subCategories = [];
        foreach($this->categoriesFromDb as $category)
        {
            if($category['parent_id'] == $parent_id)
            {
              $childrenCat = $this->buildTree($category['id']);
              if($childrenCat){
                 $category['children'] = $childrenCat;
              }
              $subCategories[] = $category;
            }
        }
        return $subCategories;
    }
    private function getCategories():array
    {
        if(self::$dbconnection){
            return self::$dbconnection;
        }else{
            $conn =  $this->entityManager->getConnection();
            $sql = 'SELECT * FROM categories';
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
}