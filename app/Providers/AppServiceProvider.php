<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\ContentDetails;
use App\Models\Destination;
use App\Models\Language;
use App\Models\ManageMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Mailchimp\Transport\MandrillTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendgrid\Transport\SendgridTransportFactory;
use Symfony\Component\Mailer\Bridge\Sendinblue\Transport\SendinblueTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            DB::connection()->getPdo();

            $data['basicControl'] = basicControl();
            $data['theme'] = template();
            $data['themeTrue'] = template(true);

            View::share($data);

            view()->composer([
                $data['theme'] . 'partials.header',
                $data['theme'] . 'sections.footer',
                $data['theme'] . 'sections.header_top',
                $data['theme'] . 'sections.account_partials',
                $data['theme'] . 'sections.relaxation_news_letter_two',
                $data['theme'] . 'sections.cookie',
                $data['theme'] . 'page',
            ], function ($view) {
                $menus = ManageMenu::whereIn('menu_section', ['header', 'footer'])->get();
                $headerMenu = $menus->where('menu_section', 'header')->first();
                $footerMenu = $menus->where('menu_section', 'footer')->first();

                $languages = Language::all();
                $code = \App\Http\Middleware\Language::getCode();
                $defaultLanguage = $languages->where('short_name', $code)->first();

                $view->with('headerMenu', $headerMenu);
                $view->with('footerMenu', $footerMenu);
                $view->with('language', $languages);
                $view->with('default', $defaultLanguage);

                $cookieContent = ContentDetails::with('content')
                    ->whereRelation('content', 'name', 'cookie')
                    ->first();
                $view->with('cookie', $cookieContent);

                $footerData = $this->prepareContentData('footer');
                $footerData['languages'] = $languages;
                $footerData['default'] = $defaultLanguage;
                if (basicControl()->theme == 'relaxation'){
                    $footerData['popular_destinations'] = Destination::select('title', 'slug')->where('status', 1)->take(4)->get();
                    $footerData['card'] = Content::select(['id','name','type','media'])->where('name','card')->where('type','multiple')->get();
                }
                $view->with('footer', $footerData);

                $view->with('header_top', $this->prepareContentData('header_top'));
                $view->with('account_partials', $this->prepareContentData('account_partials'));
                $view->with('relaxation_news_letter_two', $this->prepareContentData('relaxation_news_letter_two'));
            });

            if (basicControl()->force_ssl == 1) {
                if ($this->app->environment('production') || $this->app->environment('local')) {
                    \URL::forceScheme('https');
                }
            }

            $this->registerMailDrivers();

        } catch (\Exception $e) {
        }
    }

    private function prepareContentData($sectionName)
    {
        $contentDetails = ContentDetails::with('content')
            ->whereHas('content', function ($query) use ($sectionName) {
                $query->where('name', $sectionName);
            })
            ->get();

        $singleContent = $contentDetails->where('content.name', $sectionName)
            ->where('content.type', 'single')
            ->first();

        $multipleContents = $contentDetails->where('content.name', $sectionName)
            ->where('content.type', 'multiple')
            ->values()
            ->map(function ($multipleContentData) {
                return collect($multipleContentData->description)
                    ->merge($multipleContentData->content->only('media'));
            });

        return [
            'single' => $singleContent ? collect($singleContent->description)->merge($singleContent->content->only('media')) : [],
            'multiple' => $multipleContents,
        ];
    }

    private function registerMailDrivers()
    {
        $drivers = [
            'sendinblue' => SendinblueTransportFactory::class,
            'sendgrid' => SendgridTransportFactory::class,
            'mandrill' => MandrillTransportFactory::class,
        ];

        foreach ($drivers as $driver => $factory) {
            Mail::extend($driver, function () use ($factory, $driver) {
                return (new $factory)->create(
                    new Dsn("{$driver}+api", 'default', config("services.{$driver}.key"))
                );
            });
        }
    }
}
