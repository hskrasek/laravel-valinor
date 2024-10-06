TODO:

[//]: # (* Finish mapping configuration to mapper)
* New impl of http. ParsedRequest in place of FormRequest
  * Combine validation with parsing
  * Attribute applied attribution rules to support different validator rules not covered by parsing
* Setup argument mapper binding
  * Will require config refactor
* Default source format & transformer setup
  * Custom source objects for syntactic sugar?

Do I make validation attributes and handle validation as a transformer? Or do I lean into the
source approach, which means needing to define validation rules on the child parsed request? 
