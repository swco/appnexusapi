<?php
/**
 * @author: gareth
 */

namespace SWCO\AppNexusAPI;

use SWCO\AppNexusAPI\Services\Category;

interface IServiceFactory
{
    public function newBrandInstance();

    public function newBrandCollection(array $brandsData);

    /**
     * @return Category
     */
    public function newCategoryInstance();

    /**
     * @param array $categoriesData
     * @return Category[]
     */
    public function newCategoryCollection(array $categoriesData);
} 
