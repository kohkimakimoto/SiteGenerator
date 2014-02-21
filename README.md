# SiteGenerator 

A simple static site generator (for my personal use).

## Installation 

Create composer.json for installing via composer. 

```json
{
      "require": {
          "kohkimakimoto/site-generator": "dev-master"
      }
}
```

Run composer install command.

```Shell
$ composer install
```

## Usage

Init

```Shell
$ php bin/vendor/site init
```

Generate

```Shell
$ php bin/vendor/site generate
```

## TODO

* Support generating asset files. 
* Support efficient watch mode.

## References

It's inspired the following products.

* [sculpin](https://github.com/sculpin/sculpin)
* [jekyll](https://github.com/jekyll/jekyll)

