<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\SiteSetting;

class SiteSettingComposer
{
    /**
     * Bind data to the view
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $settings = SiteSetting::getSetting();
        $view->with('siteSetting', $settings);
    }
}
