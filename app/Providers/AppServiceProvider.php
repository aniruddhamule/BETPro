<?php

namespace App\Providers;

use App\Models\BetInvest;
use App\Models\Category;
use App\Models\Extension;
use App\Models\ExtraPage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\General;
use App\Models\Language;
use App\Models\Social;
use App\Models\Support;
use App\Models\Event;
use App\Models\Notification;
use App\Models\PaymentGateway;
use App\Models\SectionBtn;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app['request']->server->set('HTTPS', true);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // date_default_timezone_set('Asia/Dhaka');
        Schema::defaultStringLength(191);
        $data['social'] = Social::get();
        $data['extra_page'] = ExtraPage::get();
        $data['gateways'] = PaymentGateway::whereStatus(1)->get();
        $data['extension'] = Extension::get();
        $data['general'] = General::first();
        $data['section_btn'] = SectionBtn::first();
        $data['lang'] = Language::get();
        $data['slider'] = Slider::whereStatus(1)->get();
        
        $data['unver_user'] = User::where('emailv', 0)->count();
        $data['check_count'] = Support::where('status', 1)->count();

        $data['tournaments'] = Event::where('status',1)->whereHas('inplayes')->get();
        $data['recentWinners'] = BetInvest::where('status',1)->latest()->limit(5)->with('user')->get(['user_id','return_amount']);
        $data['gameCategories'] = Category::with(['event'])->withCount(['activeMatch'])->whereStatus(1)->orderBy('active_match_count', 'desc')->get();

        $data['category'] = Category::whereStatus(1)
        ->whereHas('event',function($q){
            $q->whereStatus(1);
        })->whereHas('matches',function($q){
            $q->whereStatus(1);
        })
        ->get();

        $data['upcoming_category'] = Category::whereHas('matches')->whereStatus(1)
        ->whereHas('event.matches',function($q){
            $q->whereStatus(1);
        })->whereHas('matches',function($q){
            $q->whereStatus(1)->whereDate('start_date', '>=', Carbon::now());
        })
        ->get();
        
        view()->share($data);

        view()->composer('admin.layouts.partials.nav', function ($view) {
            $view->with([
                'adminNotifications' => Notification::where('read_status',0)->with('user')->orderBy('id','desc')->get(),
            ]);
        });
    }
}
