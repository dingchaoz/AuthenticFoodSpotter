<?php

  class GroupTableSeeder extends Seeder {

    public function run()
    {
       DB::table('groups')->delete();

      Sentry::getGroupProvider()->create(array(
                                           'name'        => 'users',
                                           'permissions' => array(
                                             'admin' => 0,
                                             'users' => 1,
                                           )));

      Sentry::getGroupProvider()->create(array(
                                           'name'        => 'admin',
                                           'permissions' => array(
                                             'admin' => 1,
                                             'users' => 1,
                                           )));


      // $user = Sentry::createUser(array(
      //     'email'     => 'admin@yelp.com',
      //     'password'  => 'admin',
      //     'first_name'=> 'admin',
      //     'last_name' => ' :) ',
      //     'username'  => 'admin',
      //     'activated' => true
      // ));

      // // Find the group using the group name
      //   $userGroup = Sentry::findGroupByName('admin');

      //   // Assign the group to the user
      //   $user->addGroup($userGroup);





    }



  }