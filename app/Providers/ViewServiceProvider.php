<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\FooterGridOne;
use App\Models\FooterGridThree;
use App\Models\FooterGridTwo;
use App\Models\FooterInfo;
use App\Models\FooterTitle;
use App\Models\Language;
use App\Models\SocialLink;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('frontend.layouts.master', function ($view) {
            $language = getLanguage();

            $footerTitles = FooterTitle::where('language', $language)
                ->whereIn('key', ['grid_one_title', 'grid_two_title', 'grid_three_title'])
                ->get()
                ->keyBy('key');

            $view->with([
                'languages'            => Language::where('status', 1)->get(),
                'categories'           => Category::where(['status'=> 1, 'language'=> $language, 'show_at_nav'=> 0])->get(),
                'featuredCategories'   => Category::where(['status'=> 1, 'language'=> $language, 'show_at_nav'=> 1])->get(),
                'socialLinks'          => SocialLink::where('status', 1)->get(),
                'footerInfo'           => FooterInfo::where('language', $language)->first(),
                'footerGridOne'        => FooterGridOne::where(['status' => 1, 'language' => $language])->get(),
                'footerGridTwo'        => FooterGridTwo::where(['status' => 1, 'language' => $language])->get(),
                'footerGridThree'      => FooterGridThree::where(['status' => 1, 'language' => $language])->get(),
                'footerGridOneTitle'   => $footerTitles->get('grid_one_title'),
                'footerGridTwoTitle'   => $footerTitles->get('grid_two_title'),
                'footerGridThreeTitle' => $footerTitles->get('grid_three_title'),
            ]);
        });
    }
}

// شايف الفرق
            // 'footerGridOneTitle'=> FooterTitle::where(['key' => 'grid_one_title', 'language' => $language])->first(),
            // 'footerGridTwoTitle'=> FooterTitle::where(['key' => 'grid_two_title', 'language' => $language])->first(),
            // 'footerGridThreeTitle'=> FooterTitle::where(['key' => 'grid_three_title', 'language' => $language])->first()
