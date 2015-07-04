<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Pleo\BSG\Entities\User;
use Pleo\BSG\Entities\UserRepository;

require_once __DIR__ . '/../../bootstrap.php';

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given A user :user exists with phone :phone
     */
    public function givenAUserExists($username, $phone)
    {
        // This is ugly here. I'm sure there's a better way to do this...
        require_once __DIR__ . '/../../bootstrap.php';
        $em = \Pleo\BSG\getEM();
        /** @var UserRepository $userRepo */
        $userRepo = $em->getRepository('\\Pleo\\BSG\\Entities\\User');
        $user = $userRepo->getByUsername($username);
        if (!$user) {
            static::visit('/register');
            static::fillField('Display Name', $username);
            static::fillField('Username', $username);
            static::fillField('Password', 'password');
            static::fillField('Phone', $phone);
            static::pressButton('Register');
        }
    }

    /**
     * @Given I log in as :user
     */
    public function iAmLoggedInAs($user)
    {
        static::visit('/');
        static::fillField('username', $user);
        static::fillField('password', 'password');
        static::pressButton('Login');
    }

    /**
     * @BeforeFeature
     */
    public static function clearDB()
    {
        exec('vendor/bin/doctrine orm:schema-tool:drop --force');
        exec('vendor/bin/doctrine orm:schema-tool:create');
    }
}
