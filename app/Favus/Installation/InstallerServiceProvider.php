<?php

namespace Favus\Installation;

use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider {

  public function register()
  {
    $this->app->bind('installer', function () {

    	return new Installer;
    	
    });
  }

}