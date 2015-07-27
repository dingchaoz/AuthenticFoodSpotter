<?php

  class SettingTableSeeder extends Seeder {

    public function run()
    {
      $setting = new Setting;
      $setting->option = "banner1";
      $setting->value = "<img src='http://gentleninja.com/blog/wp-content/uploads/2014/01/Blog-Banner-2.jpg' style='display:block; margin: 0 auto; margin-top: 10px;'>";
      $setting->save();     

      $setting = new Setting;
      $setting->option = "featuredAdCost";
      $setting->value = "3";
      $setting->save();           
    }



  }