<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
	protected $repositories = ['User'];

	 /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as  $repository) {
            $this->app->bind(
                "App\\Services\\Contracts\\$repository"."ServiceInterface",
                "App\\Services\\$repository"."Service"
            );
        }
    }
}
