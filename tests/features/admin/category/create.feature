Feature: Create Category
  Background:
    Given I login as admin
    And I am on "/admin/harentius/blog/category/create"
    When I fill in "Name" with "New Category"
    And I press "Create"

  Scenario: Category with no articles not shown to users
    When I am on homepage
    Then I should not see "New Category"
