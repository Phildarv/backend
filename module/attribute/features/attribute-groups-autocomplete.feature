Feature: Attribute groups autocomplete

  Scenario: Get attribute groups autocomplete
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "attribute/features/attribute.json"

  Scenario: Get attribute groups autocomplete (not authorized)
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete"
    Then the response status code should be 401

  Scenario: Get attribute groups autocomplete (order by code)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete?field=code"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "attribute/features/attribute.json"

  Scenario: Get attribute groups autocomplete (order by code)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete?field=code"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "attribute/features/attribute.json"

  Scenario: Get attribute groups autocomplete (order by label)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete?field=label"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "attribute/features/attribute.json"

  Scenario: Get attribute groups autocomplete (order ASC)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete?field=code&order=ASC"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "attribute/features/attribute.json"

  Scenario: Get attribute groups autocomplete (order DESC)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete?field=code&order=DESC"
    Then the response status code should be 200
    And the JSON should be valid according to the schema "attribute/features/attribute.json"

  Scenario: Get attribute groups autocomplete (search f limit 1)
    Given I am Authenticated as "test@ergonode.com"
    And I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    When I send a GET request to "/api/v1/en_GB/attributes/groups/autocomplete?search=f&limit=1"
    And the JSON should be valid according to the schema "attribute/features/attribute.json"
