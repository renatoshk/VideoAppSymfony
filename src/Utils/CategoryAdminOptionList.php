<?php


namespace App\Utils;


use App\Utils\AbstractClasses\CategoryAbstract;

class CategoryAdminOptionList extends CategoryAbstract
{
    public function getCategoryList(array $categories_array , int $count = 0)
    {
        foreach($categories_array as $category){
            $this->treeCategoryHtml[] = [
                'name'=>str_repeat("-", $count).$category['name'],
                'id'=>$category['id']
            ];
            if(!empty($category['children'])){
                $count = $count + 2;
                $this->getCategoryList($category['children'], $count);
                $count = $count-2;
            }
        }
        return $this->treeCategoryHtml;
    }

}