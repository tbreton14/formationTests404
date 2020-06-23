Feature: Recipe
  Scenario: Create a recipe
    Given an empty recipe
    When I create a recipe with two products
    Then the recipe is created