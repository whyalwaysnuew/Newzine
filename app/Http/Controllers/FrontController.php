<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\ArticleNews;
use Illuminate\Http\Request;
use App\Models\BannerAdvertisement;

class FrontController extends Controller
{
    public function index()
    {
        $title = 'Newzine | Newest Magazine Everyday';
        $categories = Category::all();
        $authors = Author::all();
        $articles = ArticleNews::with(['category'])
                    ->where('is_featured', 'not_featured')
                    ->latest()
                    ->take(3)
                    ->get();
        $featured_articles = ArticleNews::with(['category'])
                    ->where('is_featured', 'featured')
                    ->inRandomOrder()
                    ->take(3)
                    ->get();
        $bannerads = BannerAdvertisement::where('is_active', 'active')
                    ->where('type', 'banner')
                    ->inRandomOrder()
                    ->first();
        $entertainment_featured = ArticleNews::whereHas('category', function($query){
                                    $query->where('name', 'Entertainment');
                                })
                                ->where('is_featured', 'featured')
                                ->inRandomOrder()
                                ->first();
        $entertainment_articles = ArticleNews::whereHas('category', function($query){
                                    $query->where('name', 'Entertainment');
                                })
                                ->where('is_featured', 'not_featured')
                                ->latest()
                                ->take(6)
                                ->get();
        $business_featured = ArticleNews::whereHas('category', function($query){
                                    $query->where('name', 'Business');
                                })
                                ->where('is_featured', 'featured')
                                ->inRandomOrder()
                                ->first();
        $business_articles = ArticleNews::whereHas('category', function($query){
                                    $query->where('name', 'Business');
                                })
                                ->where('is_featured', 'not_featured')
                                ->latest()
                                ->take(6)
                                ->get();
        $automotive_featured = ArticleNews::whereHas('category', function($query){
                                    $query->where('name', 'Automotive');
                                })
                                ->where('is_featured', 'featured')
                                ->inRandomOrder()
                                ->first();
        $automotive_articles = ArticleNews::whereHas('category', function($query){
                                    $query->where('name', 'Automotive');
                                })
                                ->where('is_featured', 'not_featured')
                                ->latest()
                                ->take(6)
                                ->get();

        return view('front.index', compact(
            'title',
            'entertainment_featured',
            'entertainment_articles',
            'business_featured',
            'business_articles',
            'automotive_featured',
            'automotive_articles',
            'categories',
            'authors',
            'articles',
            'featured_articles',
            'bannerads'
        ));
    }

    public function details(ArticleNews $articleNews)
    {
        $title = 'Article | Newest Magazine Everyday';
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
                    ->where('is_featured', 'not_featured')
                    ->where('id', '!=', $articleNews->id)
                    ->latest()
                    ->take(3)
                    ->get();

        $others = ArticleNews::with(['category'])
                    ->where('author_id', $articleNews->author_id)
                    ->where('id', '!=', $articleNews->id)
                    ->latest()
                    ->take(3)
                    ->get();


        $bannerads = BannerAdvertisement::where('is_active', 'active')
                    ->where('type', 'banner')
                    ->inRandomOrder()
                    ->first();

        return view('front.details', compact('title', 'categories', 'articleNews', 'articles', 'others', 'bannerads'));
    }

    public function category(Category $category)
    {
        $categories = Category::all();
        $title = "Categories";
        $bannerads = BannerAdvertisement::where('is_active', 'active')
                    ->where('type', 'banner')
                    ->inRandomOrder()
                    ->first();

        return view('front.category', compact('title', 'category', 'categories', 'bannerads'));
    }

    public function author(Author $author)
    {
        $categories = Category::all();
        $title = 'Author | ' . $author->name;
        $bannerads = BannerAdvertisement::where('is_active', 'active')
                    ->where('type', 'banner')
                    ->inRandomOrder()
                    ->first();

        return view('front.author', compact('title', 'author', 'categories', 'bannerads'));
    }

    public function search(Request $request)
    {
        $title = "Search";

        $request->validate([
            'keyword' => ['required', 'string', 'max:255']
        ]);

        $categories = Category::all();

        $keyword = $request->keyword;

        $articles = ArticleNews::with(['category', 'author'])->where('name', 'like', '%' . $keyword . '%')->paginate(6);

        return view('front.search', compact('title', 'articles', 'keyword', 'categories'));
    }
}
