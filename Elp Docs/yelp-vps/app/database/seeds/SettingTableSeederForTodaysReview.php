<?php

  class SettingTableSeederForTodaysReview extends Seeder {

    public function run()
    {
      $setting = new Setting;
      $setting->option = "reviewOfTheDay";
      $setting->value = "0";
      $setting->save();           
    }



  }