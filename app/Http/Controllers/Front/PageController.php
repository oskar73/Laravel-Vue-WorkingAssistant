<?php

namespace App\Http\Controllers\Front;

use App\Enums\ModuleEnum;
use App\Http\Controllers\Controller;
use App\Models\Module\BlogPost;
use App\Models\Module\EcommerceCategory;
use App\Models\Module\EcommerceProduct;
use App\Models\AppointmentCategory;
use App\Models\Page;

class PageController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Page();
    }

    public function index($url = null)
    {
        $website = tenant();

        if ($website) {
            $page = $this->model->where('url', $url)
                ->orWhere('url', '')
                ->orWhere('url', '/')
                ->where('status', 1)
                ->first();

            $data = null;
            $seo = null;

            if ($page) {
                $data = optional($page->data);
                if ($data['seo']) {
                    $seo['meta_title'] = $data['seo']['title'];
                    $seo['meta_description'] = extractDesc($data['seo']['description']);
                    $seo['meta_keywords'] = $data['seo']['keywords'];
                    $seo['meta_image'] = $data['seo']['image'] ?? $page->getFirstMediaUrl('seo');
                } else {
                    $seo['meta_title'] = $data['meta_title'];
                    $seo['meta_description'] = extractDesc($data['meta_description']);
                    $seo['meta_keywords'] = $data['meta_keywords'];
                    $seo['meta_image'] = $page->getFirstMediaUrl('seo');
                }
            }

            $activeModules = tenant('p_modules');
            $modules = [
                'activeModules' => $activeModules
            ];

            if (count($activeModules)) {
                if (in_array('simple_blog', $activeModules)) {
                    $blogPosts = BlogPost::status('approved')->orderBy('featured', 'desc')->orderBy('created_at', 'desc')->get();
                    $blogPage = Page::where('type', 'module')->where('name', 'Blog')->first();
                    if ($blogPage) {
                        $blogPage->url = $website->module_url['blog'] ?? $blogPage->url;
                    }

                    $modules['blog'] = [
                        'posts' => $blogPosts ?? [],
                        'page' => $blogPage ?? null,
                        'detail' => $website->module_url['blogDetail'] ?? 'detail'
                    ];
                }

                if (in_array(ModuleEnum::ECOMMERCE, $activeModules)) {
                    $productCategories = EcommerceCategory::status(1)->get();
                    $products = EcommerceProduct::status(1)
                        ->with('standardPrice')
                        ->orderBy('featured', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->get();
                    $productPage = Page::where('type', 'module')->where('name', 'Ecommerce')->first();
                    if ($productPage) {
                        $productPage->url = $website->module_url['ecommerce'] ?? $productPage->url;
                    }

                    $modules['ecommerce'] = [
                        'products' => $products ?? [],
                        'page' => $productPage ?? null,
                    ];
                }

                if (in_array(ModuleEnum::APPOINTMENT, $activeModules)) {
                    $appointmentCategories = AppointmentCategory::status(1)->get();

                    $modules['appointment'] = [
                        'categories' => $appointmentCategories ?? [],
                    ];
                }
            }

            $data = [
                'website' => $website,
                'data' => $data,
                'seo' => $seo,
                'url' => $url,
                'modules' => $modules
            ];

            return view('frontend.v2', $data);
        }

        return  view('welcome');
    }

    public function getWebsiteData()
    {
        $website = tenant();

        $activeModules = tenant('p_modules');

        if (count($activeModules)) {
            if (in_array('simple_blog', $activeModules)) {
                $blogPosts = BlogPost::status('approved')->orderBy('featured', 'desc')->orderBy('created_at', 'desc')->get();
                $blogPage = Page::where('type', 'module')->where('name', 'Blog')->first();
            }
        }

        return [
            'success' => true,
            'template' => $website,
            'modules' => [
                'activeModules' => $activeModules,
                'blog' => [
                    'posts' => $blogPosts ?? [],
                    'page' => $blogPage ?? null,
                ],
            ],
        ];
    }
}
