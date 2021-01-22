<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ModuleEnum;
use App\Models\BizinaModule;
use App\Models\Page;
use App\Models\StripeAccount;
use App\Models\PaypalAccount;
use App\Models\WebsiteModule;
use Illuminate\Http\Request;

class ModuleController extends AdminController
{
    public function __construct(WebsiteModule $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return view('admin.module.index');
    }

    public function getMyModules()
    {
        $modules = $this->model->get();
        $my_modules = $modules->where('status', 1);
        $my = view('components.admin.myModuleTable', [
            'modules' => $my_modules,
            'selector' => 'datatable-my',
        ])->render();

        $canceled_modules = $modules->where('status', 0);
        $disabled = view('components.admin.canceledModuleTable', [
            'modules' => $canceled_modules,
            'selector' => 'datatable-canceled',
        ])->render();
        $count['my'] = $my_modules->count();
        $count['canceled'] = $canceled_modules->count();

        $web = tenant();
        $limit['module'] = $web->module_limit == -1 ? 'Unlimited' : $web->module_limit;
        $limit['fmodule'] = $web->fmodule_limit == -1 ? 'Unlimited' : $web->fmodule_limit;

        return response()->json([
            'status' => 1,
            'my' => $my,
            'canceled' => $disabled,
            'count' => $count,
            'limit' => $limit,
        ]);
    }

    public function getAllModules()
    {
        $all_modules = BizinaModule::with('category:id,name,slug')
            ->where('status', 1)
            ->orderBy('featured', 'DESC')
            ->orderBy('new', 'DESC')
            ->get(['name', 'category_id', 'slug', 'featured', 'status', 'new']);

        $limits = $this->getModuleLimits();
        $c_modules = tenant('c_modules');

        $all = view('components.admin.allModuleTable', [
            'modules' => $all_modules,
            'limits' => $limits,
            'c_modules' => $c_modules,
            'selector' => 'datatable-all',
        ])->render();

        return response()->json([
            'status' => 1,
            'all' => $all,
            'count' => $all_modules->count(),
        ]);
    }

    public function getModuleLimits($return_value = null)
    {
        $web = tenant();
        $module_limit = $web->module_limit;
        $fmodule_limit = $web->fmodule_limit;

        $modules = $this->model->get();
        $current_module = $modules->where('status', 1)->count();
        $featured_module = $modules->where('status', 1)->where('featured', 1)->count();

        $result['module'] = 0;
        $result['fmodule'] = 0;

        if ($module_limit == -1 || ($module_limit - $current_module) > 0) {
            $result['module'] = 1;
        }
        if ($fmodule_limit == -1 || ($fmodule_limit - $featured_module) > 0) {
            $result['fmodule'] = 1;
        }
        if ($return_value == 'module') {
            return $result['module'];
        }
        if ($return_value == 'fmodule') {
            return $result['fmodule'];
        }

        return $result;
    }

    public function getModule(Request $request)
    {
        $module = BizinaModule::where('slug', $request->module)
            ->where('status', 1)
            ->firstorfail();

        $limits = $this->getModuleLimits();
        if ($limits['module'] == 0) {
            return response()->json(['status' => 0, 'data' => ['Your module count is already reached to limit.']]);
        }
        if ($limits['fmodule'] == 0 && $module->featured) {
            return response()->json(['status' => 0, 'data' => ['Your featured module count is already reached to limit.']]);
        }

        $new_module = $this->model->where('slug', $module->slug)->first();
        if ($new_module == null) {
            $new_module = $this->model;
            $new_module->slug = $module->slug;
        }
        $new_module->name = $module->name;
        $new_module->featured = $module->featured;
        $new_module->status = 1;
        $new_module->publish = 0;
        $new_module->save();

        return response()->json([
            'status' => 1,
            'data' => 1,
        ]);
    }

    public function switchModule(Request $request)
    {
        $action = $request->action;

        $module = WebsiteModule::where('status', 1)
            ->where('slug', $request->module)
            ->firstorfail();

        if ($module->slug == ModuleEnum::ECOMMERCE && $action == 'publish') {
            if (!count(tenant()->gateway())) {
                return response()->json([
                    'status' => 0,
                    'action' => 'payment',
                ]);
            }
        }

        if ($action == 'publish') {
            $module->publish = 1;
        } elseif ($action == 'unpublish') {
            $module->publish = 0;
        } elseif ($action == 'cancel') {
            $module->status = 0;
            $module->publish = 0;
        }

        $module->save();

        if ($module->publish) {
            $pageModules = [
                ['slug' => ModuleEnum::SIMPLE_BLOG, 'url' => '/blog', 'name' => 'Blog'],
                ['slug' => ModuleEnum::ADVANCED_BLOG, 'url' => '/blog', 'name' => 'Blog'],
                ['slug' => ModuleEnum::ECOMMERCE, 'url' => '/ecommerce'],
                ['slug' => ModuleEnum::DIRECTORY, 'url' => '/directory'],
                // ['slug' => ModuleEnum::APPOINTMENT, 'url' => '/appointment']
            ];
            $moduleSlugs = array_column($pageModules, 'slug');
            $moduleIndex = array_search($module->slug, $moduleSlugs);
            
            if ($moduleIndex > -1) {
                $page = Page::where('web_id', tenant()->id)
                    ->where('name', $pageModules[$moduleIndex]['name'] ?? $module->name)
                    ->where('type', 'module')
                    ->where('module_name', $module->slug)
                    ->where('status', 1)
                    ->first();
                if (!$page) {
                    Page::firstOrCreate([
                        'web_id' => tenant()->id,
                        'name' => $pageModules[$moduleIndex]['name'] ?? $module->name,
                        'type' => 'module',
                        'module_name' => $module->slug,
                        'url' => $pageModules[$moduleIndex]['url'],
                        'data' => []
                    ]);
                }

                $page = Page::where('web_id', tenant()->id)
                    ->where('name', $pageModules[$moduleIndex]['name'] ?? $module->name)
                    ->where('type', 'module')
                    ->where('module_name', $module->slug)
                    ->where('status', 0)
                    ->first();
                if (!$page) {
                    Page::firstOrCreate([
                        'web_id' => tenant()->id,
                        'name' => $pageModules[$moduleIndex]['name'] ?? $module->name,
                        'type' => 'module',
                        'module_name' => $module->slug,
                        'url' => $pageModules[$moduleIndex]['url'],
                        'data' => [],
                        'status'    =>  0
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 1,
            'data' => [
                'module' => $module,
            ],
        ]);
    }
}
