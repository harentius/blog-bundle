Feature: Login as admin
  Scenario: Log in with correct credentials
    Given I am on "/admin/login"
    When I fill in the following:
    | username or email | admin |
    | password          | admin |
    And I press "Log in"
    Then I should be on "/admin/harentius/blog/article/list"
    And I should see "Article List"

  Scenario: Try to log in with invalid credentials
    Given I am on "/admin/login"
    When I fill in the following:
      | username or email | badcred |
      | password          | badcred |
    And I press "Log in"
    Then I should see "Invalid credentials."
    And I should be on "/admin/login"