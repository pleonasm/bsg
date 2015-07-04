# Go

* Have composer around.
* Have php 5.6.x around.

Run these:

```
composer install
bin/from-scratch
```

PROFIT.

## Other Notes

You can run the test suite with `vendor/bin/behat`. Just realize that it
*will* destroy your database when you do that. If you want to keep your db
around, move dat/data.sqlite somewhere else, then run the test suite, then
move that file back.
