<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Pleo\BSG\Entities\User;

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
     * @Given user :user exists with phone :phone
     */
    public function givenUserExists($user, $phone)
    {
        static::visit('/register');
        static::fillField('dispname', $user);
        static::fillField('username', $user);
        static::fillField('password', 'password');
        static::fillField('phone', $phone);
        static::pressButton('Register');
    }

    /**
     * @Given I am logged in as :user
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
