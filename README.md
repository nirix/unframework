# Unframework

Unframework is **not** a framework, it is essentially just a few classes (most static)
to handle initialisation and route a request to a specific file.

There are no controllers, no database models, no templating systems.

An example site can be found in the `app/` directory.

## Requirements

- Latest, _actively supported_, stable version of PHP

### Recommended

- OPcache
- PHP 7.0+

## Questions

### But controllers, I want them...

No, you don't.

### But I need a database...

PHP's [PDO][1] is the best.

### But I want an ORM to hog my memory...

You're doing it wrong. Learn to write SQL, it's not hard.

### But I want Twig (or some other templating system)

You know nothing, John Snow.

### No really, I do.

[Here you go][2].

## License

````
Copyright (c) 2015 Jack P.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.  IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
````

[1]: https://php.net/manual/en/intro.pdo.php
[2]: http://bfy.tw/3HyY
