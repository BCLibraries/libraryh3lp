# LibraryH3lp

`libraryh3lp` is a PHP module for linking to the LibraryH3lp chat. For sites that have multiple queues, it determines the best available queue to link.

## Installation

Use the composer package manager:

```bash
composer require bclibraries/fulltext-finder:^1.0
```

## Usage

Minimal usage:

```php
use BCLib\Libraryh3lp\Queue;
use BCLib\Libraryh3lp\Resolver;

// Build a resolver with the LibraryH3lp queues we use, in order of preference.
$resolver = new Resolver([
    new Queue('queue-1', 'Optimal Queue'),
    new Queue('queue-2', 'Second Best Queue'),
    new Queue('queue-3', 'Backup Queue')
]);

// Get the best LibraryH3lp queue URL...
$url = $resolver->resolve();

// ...or redirect to best LibraryH3lp queue.
$resolver->redirect();
```

### Queue options

`Queue` constructors take the following arguments:

* **`code`** - (_string_) the queue's LibraryH3lp ID code
* **`title`** - (_string_) a human-readable title for the queue
* `skin` - (_string_) a numeric LibraryH3lp skin code
* `sounds` - (_bool_) enable sounds by default

```php
$queue = new Queue('queue-code', 'Queue Title', '99999', true);
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)