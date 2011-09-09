# ls-module-testimonial
Provides testimonials for your store.

## Installation
1. Download [Testimonial](https://github.com/limewheel/ls-module-testimonial/zipball/master)
1. Create a folder named `testimonial` in the `modules` directory.
1. Extract all files into the `modules/testimonial` directory (`modules/testimonial/readme.md` should exist).
1. Setup your code as described in the `Usage` section.
1. Done!

## Usage
Create a `Testimonials` page that uses the `testimonial:statements` page action, and use this content:

```php
<? foreach($statements as $statement): ?>
  <?= h($statement->content) ?>
  <br />
  By <a href="<?= h($statement->author_link) ?>"><?= h($statement->author_name) ?></a>
<? endforeach ?>
```