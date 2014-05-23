<?php namespace Lowerends\Mpdf;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Mpdf\Mpdf\Mpdf;

class ServiceProvider extends BaseServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->package('lowerends/l4-mpdf');

        if($this->app['config']->get('l4-mpdf::config.pdf.enabled')){
            $this->app['mpdf.pdf'] = $this->app->share(function($app)
            {
                $binary = $app['config']->get('l4-mpdf::config.pdf.binary');
                $options = $app['config']->get('l4-mpdf::config.pdf.options');
                $mpdf = new Pdf($binary, $options);
                return $mpdf;
            });

            $this->app['mpdf.wrapper'] = $this->app->share(function($app)
            {
                return new PdfWrapper($app['mpdf.pdf']);
            });
        }
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('mpdf.pdf', 'mpdf.wrapper');
	}

}