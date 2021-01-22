<?php

namespace App\Jobs;

use App\Models\Module\BlogCategory;
use App\Models\Module\BlogPost;
use App\Models\BlogTag;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportBlogPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ids;
    public $host;
    public $search;
    public $categories;
    public $tags;
    public $user;
    public $post_link;

    /**
     * Create a new job instance.
     */
    public function __construct($request, $user)
    {
        $this->user = $user;
        $this->ids = $request->ids;
        $this->host = $request->host;
        $this->search = $request->search;
        $this->categories = [];
        $this->tags = [];
        $this->medias = [];
        $this->post_link = null;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $wpUrl = 'https://' . $this->host . '/wp-json/wp/v2/';
        $query = '&per_page=100';
        if ($this->ids == 'all') {
            if ($this->search) {
                $query .= '&search=' . $this->search;
            }
        } else {
            $query .= '&include=' . join(',', $this->ids);
        }

        $this->get_meta_categories($wpUrl);
        $this->get_meta_tags($wpUrl);

        $this->import($wpUrl, $query, 1);

        if(!is_null($this->post_link)) {
            $parsed_url = parse_url($this->post_link);
            $path_segments = explode('/', trim($parsed_url['path'], '/'));
            array_pop($path_segments);
            $blogPath = implode('/', $path_segments);

            $website = tenant();
            $new = $website->module_url;
            $new['blog'] = $blogPath;
            $new['blogDetail'] = '';
            $website->module_url = $new;
            $website->save();
        }
    }

    public function import($wpUrl, $query, $page) {
        $url = $wpUrl . 'posts?page=' . $page . $query;
        $response = Http::withoutVerifying()->get($url);
        if ($response->successful()) {
            $posts = $response->json();
            $medias = [];
    
            foreach ($posts as $post) {
                if (isset($post['featured_media']) && $post['featured_media']) {
                    if (!in_array($post['featured_media'], $medias) && !isset($this->medias[$post['featured_media']])) {
                        $medias[] = $post['featured_media'];
                    }
                }
            }
            if (count($medias)) $this->get_meta_medias($wpUrl, $medias);
            foreach ($posts as $post) {
                try {
                    DB::beginTransaction();
                    if (isset($this->categories[$post['categories'][0]]['id'])) {
                        $categoryId = $this->categories[$post['categories'][0]]['id'];
                    } else {
                        $categoryName = $this->categories[$post['categories'][0]]['name'];
                        $category = BlogCategory::where('name', $categoryName)->first();
                        if (!$category) {
                            $category = BlogCategory::updateOrCreate($this->categories[$post['categories'][0]]);
                        }
                        $categoryId = $category->id;
                        $this->categories[$post['categories'][0]] = [
                            'name' => $this->categories[$post['categories'][0]]['name'],
                            'description' => $this->categories[$post['categories'][0]]['description'],
                            'id'    =>  $categoryId
                        ];
                    }
                    $blog = BlogPost::create([
                        'user_id'   =>  $this->user,
                        'category_id'   =>  $categoryId,
                        'title'         =>  mb_convert_encoding($post['title']['rendered'], 'UTF-8', 'HTML-ENTITIES'),
                        'body'          =>  $post['content']['rendered'],
                        'status'        =>  'approved',
                        'is_published'  =>  0,
                        'visible_date'  =>  Carbon::now()->toDateString(),
                        'gallery_order' =>  1,
                        'slug'          =>  $post['slug']
                    ]);
    
                    $tags = [];
                    if (isset($post['tags'])) {
                        foreach($post['tags'] as $postTag) {
                            if (isset($this->tags[$postTag]['id'])) {
                                $tagId = $this->tags[$postTag]['id'];
                            } else {
                                $tagName = $this->tags[$postTag]['name'];
                                $tag = BlogTag::where('name', $tagName)->first();
                                if (!$tag) {
                                    $tag = BlogTag::create([
                                        'name'  =>  $tagName
                                    ]);
                                }
                                $tagId = $tag->id;
                                $this->tags[$postTag] = [
                                    'id'    =>  $tagId,
                                    'name'  =>  $tagName
                                ];
                            }
                            array_push($tags, $tagId);
                        }
                        if (count($tags)) {
                            $blog->tags()->sync($tags);
                        }
                    }
                    if (isset($this->medias[$post['featured_media']])) {
                        $arrContextOptions=array(
                            "ssl"=>array(
                                "verify_peer"=>false,
                                "verify_peer_name"=>false,
                            ),
                        ); 
                        $imageData = file_get_contents($this->medias[$post['featured_media']], false, stream_context_create($arrContextOptions));
                        $blog->addMediaFromString($imageData)
                            ->usingFileName(guid() . ".jpg")
                            ->toMediaCollection('image');
                    }
    
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
    
                    report($e);
                }
            }
    
            if (count($posts) == 100) {
                $this->import($wpUrl, $query, $page + 1);
            }
            $this->post_link = $posts[0]['link'];
        }

        return true;
    }

    public function get_meta_tags($wpUrl, $page = 1) {
        $response = Http::withoutVerifying()->get($wpUrl . 'tags?page=' . $page . '&per_page=100');
        if ($response->successful()) {
            $tags = $response->json();

            foreach ($tags as $tag) {
                $this->tags[$tag['id']] = [
                    'name'  =>  $tag['name']
                ];
            }
    
            if (count($tags) == 100) {
                $this->get_meta_tags($wpUrl, $page + 1);
            }
        }

        return $this->tags;
    }

    public function get_meta_categories($wpUrl, $page = 1) {
        $response = Http::withoutVerifying()->get($wpUrl . 'categories?page=' . $page . '&per_page=100');
        if ($response->successful()) {
            $categories = $response->json();

            foreach ($categories as $category) {
                $this->categories[$category['id']] = [
                    'name'  =>  $category['name'],
                    'description'   =>  $category['description']
                ];
            }
    
            if (count($categories) == 100) {
                $this->get_meta_categories($wpUrl, $page + 1);
            }
        }

        return $this->categories;
    }

    public function get_meta_medias($wpUrl, $ids, $page = 1) {
        $response = Http::withoutVerifying()->get($wpUrl . 'media?page=' . $page . '&per_page=100&include=' . join(',', $ids));
        if ($response->successful()) {
            $medias = $response->json();

            foreach ($medias as $media) {
                $this->medias[$media['id']] = $media['source_url'];
            }
    
            if (count($medias) == 100) {
                $this->get_meta_medias($wpUrl, $ids, $page + 1);
            }
        }

        return $this->medias;
    }
}
