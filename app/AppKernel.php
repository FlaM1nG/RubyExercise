<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new WWW\UserBundle\UserBundle(),
            new WWW\GlobalBundle\GlobalBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new SGestion\AdminBundle\SGestionAdminBundle(),
            new WWW\ServiceBundle\ServiceBundle(),
            new WWW\OthersBundle\OthersBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new ADesigns\CalendarBundle\ADesignsCalendarBundle(),
            new WhiteOctober\TCPDFBundle\WhiteOctoberTCPDFBundle(),
            new Factura\PDFBundle\PDFBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
//            new Payum\Bundle\PayumBundle\PayumBundle(),

            new WWW\CarsBundle\CarsBundle(),
            new WWW\HouseBundle\HouseBundle(),
            /**
             * HERE ALL THE BUNDLES REQUIRED TO MAKE PAYUMBUNDLE WORK
             */
            new Payum\Bundle\PayumBundle\PayumBundle(),
            
            new Acme\PaymentBundle\AcmePaymentBundle(),
            
            new Acme\RedsysBundle\AcmeRedsysBundle(),
            
            

//            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
//            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
