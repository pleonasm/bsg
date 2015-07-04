Feature:
  In order to obtain a login
  As a new user
  I need to be able to enter registration information

  Scenario: Registration Page Exists
    Given I am on "/register"
    Then the response status code should be 200

  Scenario: Register and Login
    Given I am on "/register"
    When I fill in "dispname" with "Matt Nagi"
    And I fill in "username" with "mnagi"
    And I fill in "password" with "password"
    And I fill in "phone" with "2485551234"
    And I press "Register"
    And I fill in "username" with "mnagi"
    And I fill in "password" with "password"
    And I press "Login"
    Then I should be on "/dashboard"
