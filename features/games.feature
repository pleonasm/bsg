Feature: Creation & Management of Games
  Background:
    Given A user "mnagi" exists with phone "2345556789"
    And I log in as "mnagi"
    And I follow "Create New Game"

  Scenario: Create Game page exists
    Then the response status code should be 200
    And I should see text matching "Create New Game"

  Scenario: Creating a new game
    Given I fill in "Name" with "My New Game"
    And I press "New Game"
    Then I should be on "/games"