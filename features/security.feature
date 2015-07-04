Feature: Security

  Scenario: Dashboard page protected by login
    Given I am on "/"
    And I go to "/dashboard"
    Then I should be on "/"

  Scenario: Incorrect username or pass should not allow login
    Given I am on "/"
    And I fill in "username" with "noperson"
    And I fill in "password" with "incorrect"
    And I press "Login"
    Then I should be on "/"
    And I should see "Invalid login"

  Scenario: Logging out should kill session
    Given user "mnagi" exists with phone "2345556789"
    And I am logged in as "mnagi"
    And I follow "Logout"
    And I go to "/dashboard"
    Then I should be on "/"
