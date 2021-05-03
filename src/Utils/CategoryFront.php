<?php


namespace App\Utils;

use App\Twig\AppExtension;
use App\Utils\AbstractClasses\CategoryAbstract;

class CategoryFront extends CategoryAbstract
{
  public $html1 = '<ul>';
  public $html2 = '<li>';
  public $html3 = '<a href="';
  public $html4 = '">';
  public $html5 = '</a>';
  public $html6 = '</li>';
  public $html7 = '</ul>';
  public function getCategoryListAndParent(int $id):string
  {
      $this->slugger = new AppExtension;
      $parentData = $this->getMainParent($id);
      $this->parentName = $parentData['name'];
      $this->parentId = $parentData['id'];
      $key = array_search($id, array_column($this->categoriesFromDb, 'id'));
      $this->currentCategoryName = $this->categoriesFromDb[$key]['name'];
      $categoriesArray = $this->buildTree($parentData['id']);
      $catList = $this->getCategoryList($categoriesArray);
      return $catList;
  }
  public function getCategoryList(array $categories_array)
  {
      $this->treeCategoryHtml .= $this->html1;
      foreach($categories_array as $cat){
          $catName = $this->slugger->slugify($cat['name']);
          $url = $this->urlGenerator->generate('video_list', [
                  'categoryname'=>$catName,
                  'id'=>$cat['id']
              ]);
          $this->treeCategoryHtml .=  $this->html2.$this->html3.$url.$this->html4.$cat['name'].$this->html5;
          if(!empty($cat['children'])){
              $this->getCategoryList($cat['children']);
          }
          $this->treeCategoryHtml .= $this->html6;
      }
      $this->treeCategoryHtml .= $this->html7;
      return $this->treeCategoryHtml;
  }
  public function getMainParent(int $id):array
  {
      $key = array_search($id, array_column($this->categoriesFromDb, 'id'));
      if($this->categoriesFromDb[$key]['parent_id'] != null){
         return $this->getMainParent($this->categoriesFromDb[$key]['parent_id']);
      }else{
         return [
           'id'=>$this->categoriesFromDb[$key]['id'],
           'name'=>$this->categoriesFromDb[$key]['name'],
         ];
      }
   }
}