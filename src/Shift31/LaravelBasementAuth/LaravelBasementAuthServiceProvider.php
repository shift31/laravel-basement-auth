<?php namespace Shift31\LaravelBasementAuth;

use Illuminate\Support\ServiceProvider;
use Auth;

class LaravelBasementAuthServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('shift31/laravel-basement-auth');

        Auth::extend('basement', function()
        {
            // Return implementation of Illuminate\Auth\UserProviderInterface
            return new BasementAuthUserProvider();
        });
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('auth');
	}

}