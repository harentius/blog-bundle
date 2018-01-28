Feature: Create Article
  Scenario: Admin creates article which is accessible by non authorized users
    Given I login as admin
    And I am on "/admin/harentius/blog/article/create"
    And I fill in the following:
      | Title | Test post title |
      | Text  | Test post text  |
    And I scroll to "Published"
    And I check "Published"
    And I press "Create"
    When I am on homepage
    Then I should see "Test post title"
    And I should see "Test post text"
