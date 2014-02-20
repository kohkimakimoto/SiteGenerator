# SiteGenerator 

A static site generator (for my personal use).

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

Create `generator.yml` like the following in your project root directory.

```yaml
# `dest` is a root directory to put generated site resouces.
dest: "dest"

# `source` is a root directory to processing.
source: "source"

# `public` is a directory which is copied simply to document root.
public: "%source%/public"

# `views` is a directory which is processed to output some resouces to dest directory.
views:  "%source%/views"

# `layouts` is a directory which stores layout files.
layouts:  "%source%/layouts"

# `includes` is a directory which stores include files.
includes:  "%source%/includes"

# `helpers` is a directory which includes php files are difined some user functions.
helpers:  "%source%/helpers"
```

Create contents. You can use markdown format in the `views` directory.

Run generate command.

```Shell
$ php bin/vendor/site generate
```

See the `dest` directory.


## TODO

* Support generating asset files. 
* Support watch mode.
* Support builtin web server.

## References

It's inspired the following products.

* [sculpin](https://github.com/sculpin/sculpin)
* [jekyll](https://github.com/jekyll/jekyll)

