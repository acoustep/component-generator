# Component Generator

[![Build Status](https://travis-ci.org/acoustep/component-generator.svg?branch=master)](https://travis-ci.org/acoustep/component-generator)

Inspired by [Bourbon Refill's](http://refills.bourbon.io/) Rails generators, Component Generator is a Laravel 4 package to quickly to generate HTML components from Web Frameworks such as Twitter Bootstrap via command line.

## Getting Started

By default running the following command will create a new file in views/components/navbar.blade.php with the Twitter Bootstrap navigation bar.

```
php artisan component:generate navbar
```

If you want to change the directory the file is created in your can use the --path option

```
php artisan component:generate navbar --path="app/views"
```

To append a component to an already existing file use ```component:append```

```
php artisan component:append navbar layouts.default
```

The first argument is the component. The second argument is the template to append to - located inside of app/views.

## Installation

```
"acoustep/component-generator": "dev-master"
```

Add the service provider

```
'Acoustep\ComponentGenerator\ComponentGeneratorServiceProvider',
```

If you wish to change your settings you can run

```
php artisan config:publish acoustep/component-generator
```

Or

```
php artisan component:setup
```

## Configuration

```
'framework' => 'bootstrap3'
```

This is the name of the directory to copy views from.  Alternatives include [foundation5](http://foundation.zurb.com/docs/) and [pure1](http://purecss.io/).

```
'directory' => 'components'
```

Where the components are copied to.  This will be in the ```app/views``` directory.  To copy them to the root of ```views``` change it to an empty string.

```
'prefix' => ''
```

Put a prefix on filenames.  For instance, if you come from a Rails background and prefer to use an underscore to prefix partials then you can set that here.

```
'postfix' => '.blade.php',
'syntax' => 'blade',
```

Don't use blade? You can change to normal PHP templates with the following settings

```
'postfix' => '.php',
'syntax' => 'php',
```

## Components

### Twitter Bootstrap

* [alerts](http://getbootstrap.com/components/#alerts)
* [breadcrumb](http://getbootstrap.com/components/#breadcrumbs)
* [button-group](http://getbootstrap.com/components/#btn-groups)
* [button-dropdown](http://getbootstrap.com/components/#btn-dropdowns)
* [carousel](http://getbootstrap.com/javascript/#carousel)
* [collapse](http://getbootstrap.com/javascript/#collapse)
* [dropdown](http://getbootstrap.com/components/#dropdowns-example)
* [layout](http://getbootstrap.com/getting-started/#template)
* [form](http://getbootstrap.com/css/#forms-example)
* [form-inline](http://getbootstrap.com/css/#forms-inline)
* [form-horizontal](http://getbootstrap.com/css/#forms-horizontal)
* [jumbotron](http://getbootstrap.com/components/#jumbotron)
* [list-group](http://getbootstrap.com/components/#list-group)
* [media](http://getbootstrap.com/components/#media)
* [modal](http://getbootstrap.com/javascript/#modals)
* [nav-tabs](http://getbootstrap.com/components/#nav-tabs)
* [nav-pills](http://getbootstrap.com/components/#nav-pills)
* [navbar](http://getbootstrap.com/components/#navbar-default)
* [navbar-fixed-top](http://getbootstrap.com/components/#navbar-fixed-top)
* [navbar-fixed-bottom](http://getbootstrap.com/components/#navbar-fixed-bottom)
* [navbar-static-top](http://getbootstrap.com/components/#navbar-static-top)
* [pagination](http://getbootstrap.com/components/#pagination)
* [pagination-pager](http://getbootstrap.com/components/#pagination-pager)
* [page-header](http://getbootstrap.com/components/#page-header)
* [panels](http://getbootstrap.com/components/#panels)
* [progress](http://getbootstrap.com/components/#progress)
* [progress-animated](http://getbootstrap.com/components/#progress-animated)
* [progress-stacked](http://getbootstrap.com/components/#progress-stacked)
* [thumbnails](http://getbootstrap.com/components/#thumbnails)
* [wells](http://getbootstrap.com/components/#wells)

### Zurb Foundation

* accordion
* alerts
* breadcrumb
* button-dropdown
* button-group
* button-split
* equalizer
* form
* iconbar
* joyride
* layout
* modal
* offcanvas
* orbit
* pagination
* panel
* pricing-table
* progress
* range-slider
* table
* tabs-vertical
* tabs
* thumbnails
* tooltip
* topbar
* video

### Pure

* form-aligned
* form-inline
* form-multi
* form
* layout
* menu
* pagination
* table

## To do

* A command that lists the components that are available.
* Ability to publish views for customising before generation.

## Credits

The base of this code is from Jeffrey Way's Book [Laravel Testing Decoded](https://leanpub.com/laravel-testing-decoded).  A great book which has helped me a lot!
