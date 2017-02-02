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
//            new Payum\Bundle\PayumBundle\PayumBundle(),

            new WWW\CarsBundle\CarsBundle(),
            /**
             * HERE ALL THE BUNDLES REQUIRED TO MAKE PAYUMBUNDLE WORK
             */
            new Payum\Bundle\PayumBundle\PayumBundle(),
            new Acme\DemoBundle\AcmeDemoBundle(),
            new Acme\PaymentBundle\AcmePaymentBundle(),
            new Acme\PaypalExpressCheckoutBundle\AcmePaypalExpressCheckoutBundle(),
            new Acme\StripeBundle\AcmeStripeBundle(),
            new Acme\RedsysBundle\AcmeRedsysBundle(),
            new Acme\PayexBundle\AcmePayexBundle(),
            new Acme\KlarnaBundle\AcmeKlarnaBundle(),
            new Acme\OtherExamplesBundle\AcmeOtherExamplesBundle(),

            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
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
