# plazy
Another functional library for PHP 7.

## Quickstart

To use _plazy_ in your projects install _composer_ and add to your _composer.json_ file:
```json
"require": {
    "mpstyle/plazy": "0.2.3"
}
```

Or run:
```
composer require "mpstyle/plazy"
```

## Sequence
The sequence class allows you to build up a computation out of smaller operations. It's similar to Java 8 Streams

Now we can try some of the following:
```php
Sequence::sequence(1, 2, 3, 4)->filter(even); // lazily returns 2,4
Sequence::sequence(1, 2)->map(toString); // lazily returns "1", "2"
Sequence::sequence(1, 2, 3)->take(2); // lazily returns 1,2
Sequence::sequence(1, 2, 3)->drop(2); // lazily returns 3
Sequence::sequence(1, 2, 3)->tail(); // lazily returns 2,3
Sequence::sequence(1, 2, 3)->head(); // eagerly returns 1
Sequence::sequence(1, 3, 5)->find(even); // eagerly returns none()
Sequence::sequence(1, 2, 3)->contains(2); // eagerly returns true
Sequence::sequence(1, 2, 3)->toString(":"); // eagerly returns "1:2:3"
```

## Option
Optional value - type-safe null

## Functions
plazy provides some interfaces for functional uages, such as:

- F: to transform an object to another one.
- Predicate: to filter/select/match an object.
- Validator: to validate an object.

## Developers

To run unit test, run in the root of the plazy project:
```
composer phptest
```
