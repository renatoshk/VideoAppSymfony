<?php


namespace App\Utils;


use App\Utils\AbstractClasses\CategoryAbstract;

class CategoryAdminTree extends CategoryAbstract
{
    public $html1 = '<ul class="fa-ul text-left">';
    public $html2 = '<li><i class="fa-li fa fa-arrow-right"></i>';
    public $html3 = '<a href="';
    public $html4 = '">';
    public $html5 = '</a><a onclick="return confirm(\'Are you sure?\');" href="';
    public $html6 = '">';
    public $html7 = '</a>';
    public $html8 = '</li>';
    public $html9 = '</ul>';
    public function getCategoryList(array $categories_array)
    {
        $this->treeCategoryHtml .= $this->html1;
        foreach($categories_array as $cat){
            $urlEdit = $this->urlGenerator->generate('edit_category', ['id'=>$cat['id']]);
            $urlDelete = $this->urlGenerator->generate('delete_category', ['id'=>$cat['id']]);
            $this->treeCategoryHtml .= $this->html2.$cat['name'].$this->html3.$urlEdit.$this->html4.' Edit'.$this->html5.$urlDelete.$this->html6.' Delete'.$this->html7;
            if(!empty($cat['children'])){
                $this->getCategoryList($cat['children']);
            }
            $this->treeCategoryHtml .= $this->html8;
        }
        $this->treeCategoryHtml .= $this->html9;
        return $this->treeCategoryHtml;
    }

}