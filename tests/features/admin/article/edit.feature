Feature: Edit existing article
  Scenario: Edit existing article
    Given I login as admin
    And I am on "admin/harentius/blog/article/list"
    And I click on "Edit" action for entity with "Title" "Title 1"
    When I fill in "Title" with "New Title Instead of Title 1"
    And I press "Update"
    And I am on homepage
    Then I should see "New Title Instead of Title 1"
