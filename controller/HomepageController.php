<?php
/**
 * Created by PhpStorm.
 * User: Yardie
 * Date: 05.01.2018
 * Time: 15:31
 */

namespace controller;

use service\ListingServiceImpl;
use view\LayoutRendering;
use view\TemplateView;

class HomepageController
{
    public static function show()
    {
        $contentView = new TemplateView("view/homepage.php");
        $contentView->listings = (new ListingServiceImpl())->findTopTen();
        LayoutRendering::basicLayout($contentView);
    }
}