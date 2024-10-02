<?php

namespace App\Http\Controllers\SheetTemplate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SheetTemplateImport;
use App\Models\{Brand, Category, Collection, Product, SubCategory};
use App\Traits\HelperFunctions;

class SheetTemplateController extends Controller
{

    /**
     * Receives a sheet and processes its data.
     *
     * @param Request $request The HTTP request object.
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException If the file does not exist.
     * @return void
     */
    public function receiveSheet(Request $request)
    {
        $filePath = $request->sheet;


        $data = Excel::toArray(new SheetTemplateImport, $filePath);
        foreach ($data[0] as $row) {
            dd($row);
            $this->createOrUpdateProduct($row,$data[0]);
        }
    }

    /**
     * Creates or updates a product based on the provided row data.
     *
     * @param array $row The row data containing product information.
     * @return void
     */
    private function createOrUpdateProduct($row,$data)
    {
        $product = Product::where('sku', $row['code'])->first();

        if (!isset($product) || empty($product)) {
            $categoryId = $this->createOrUpdateCategory($row);
            
            $brandId = $this->createOrUpdateBrand($row);
            
            $categoryId = $this->createOrUpdateCategory($row);

            $collectionId = $this->createOrUpdateCollection($row,$data);

            $product = Product::create([
                'name_ar' => $row['arabic_name'],
                'name_en' => $row['english_name'],
                'price' => $row['sale_price'],
                'price_after_discount' => $row['sale_price'],
                'sku' => $row['code'],
                'brand_id' => $brandId,
                'best_seller' => 0,
                'description_ar' => $row['arabic_name'] ?? $row['arabic_name'],
                'description_en' => $row['english_name'] ?? $row['english_name'],
            ]);

            if (isset($categoryId) && !empty($categoryId)) {
                $product->categories()->syncWithoutDetaching([$categoryId]);
            }
        }
    }

    /**
     * Creates or updates a category based on the provided row data.
     *
     * @param array $row The row data containing category information.
     * @return int|null The ID of the created or updated category, or null if no category was created.
     */
    private function createOrUpdateCategory($row)
    {
        if ($row['english_main_category']) {
            $category = Category::with('subCategories')
                ->where('name_en', $row['english_main_category'])
                ->first();

            if (empty($category) || $category == null) {
                $slugCategory = HelperFunctions::makeSlug($row['english_main_category']) . '-' . HelperFunctions::makeSlug($row['Code']);
                $slugSubCategory = HelperFunctions::makeSlug($row['english_sub_category']) . '-' . HelperFunctions::makeSlug($row['Code']);

                $category = Category::create([
                    'name_en' => $row['english_main_category'],
                    'name_ar' => $row['arabic_main_category'],
                    'slug' => $slugCategory,
                ]);

                $subcategory = SubCategory::firstOrCreate([
                    'name_ar' => $row['arabic_sub_category'],
                    'name_en' => $row['english_sub_category'],
                    'slug' => $slugSubCategory,
                ]);

                $subcategory->categories()->syncWithoutDetaching([$category->id]);
            }

            return $category->id;
        }

        return null;
    }

    /**
     * Creates or updates a subcategory based on the provided row data.
     *
     * @param array $row The row data containing subcategory information.
     *                  The array should have the following keys:
     *                  - 'arabic_sub_category': The Arabic name of the subcategory.
     *                  - 'english_sub_category': The English name of the subcategory.
     *                  - 'Code': The code of the subcategory.
     * @return int The ID of the created or updated subcategory.
     */
    private function createOrUpdateSubCategory($row)
    {
        $slugSubCategory = HelperFunctions::makeSlug($row['english_sub_category']) . '-' . HelperFunctions::makeSlug($row['Code']);

        return SubCategory::firstOrCreate([
            'name_ar' => $row['arabic_sub_category'],
            'name_en' => $row['English Sub Category'],
            'slug' => $slugSubCategory,
        ])->id;
    }

    /**
     * Creates or updates a brand based on the provided row data.
     *
     * @param array $row The row data containing brand information.
     *                  The array should have the following keys:
     *                  - 'English Brand': The English name of the brand.
     *                  - 'Arabic Brand': The Arabic name of the brand.
     * @return int|null The ID of the created or updated brand, or null if no brand was created.
     */
    private function createOrUpdateBrand($row)
    {
        if ($row['brand_name']) {
            $Brand = Brand::where('name_en', $row['brand_name'])
                ->first();

            if (empty($Brand) || $Brand == null) {

                $Brand = Brand::create([
                    'name_en' => $row['brand_name'],
                    'name_ar' => $row['brand_name'],
                ]);
            }

            return $Brand->id;
        }

        return null;
    }

    /**
     * Creates or updates a collection based on the provided row data.
     *
     * @param array $row The row data containing collection information.
     *                  The array should have the following keys:
     *                  - 'English Collection': The English name of the collection.
     *                  - 'Arabic Collection': The Arabic name of the collection.
     * @return int|null The ID of the created or updated collection, or null if no collection was created.
     */
    private function createOrUpdateCollection($row,$data)
    {
        foreach ($data[0] as  $item) {
            if ($item['code'] == $row['code']) {
                if ($row['English Collection']) {
                    $collection = Collection::where('name_en', $item['English Collection'])
                        ->first();   
                }
            }
     
        }
      
    }   
}
