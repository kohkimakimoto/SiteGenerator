# SiteGenerator 

A simple static site generator.

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

Run `init` command to create a basic directory structure and `generator.yml`.

```Shell
$ php bin/vendor/site init
```

Created directory structure is the following

```
.
├── dest             # Root directory to put generated site resouces.
├── source           # Site source root directory.
│   ├── helpers      # Helpers contains PHP files are difined some user functions.
│   ├── layouts      # Layouts contains a layout files.
│   ├── public       # Public is simply copied to document root.
│   └── views        # Views is processed to output files to dest directory.
└── generator.yml    # Main configuration file.
```

Run `generate` command to generate a static site from a source. 

```Shell
$ php bin/vendor/site generate
```

Also, you can run `generate` command with `--watch` and `--server` options in the development stage.

```Shell
$ php bin/vendor/site generate --watch --server
```

If you use `--server` option, You can see the site at `http://localhost:1234/`.

## TODO

* Supporting to generate asset files.

## References

It's inspired the following products.

* [sculpin](https://github.com/sculpin/sculpin)
* [jekyll](https://github.com/jekyll/jekyll)

