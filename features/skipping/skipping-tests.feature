Feature: Skipping tests based on tags

  Scenario: Test matches tag
    Given I have a test tagged "php:~5.0"
    And the current major version of PHP is "5"
    When I run the tests
    Then the test should not be skipped

  @smoke
  Scenario: Test does not match tag
    Given I have a test tagged "php:~7.0"
    And the current major version of PHP is "5"
    When I run the tests
    Then the test should be skipped
