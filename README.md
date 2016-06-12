# Sculpin Multilingual Bundle

## Description

This extension was created to handle a Sculpin multi-lingual site where each language occupies a separate subdomain.

Out of the box Sculpin can already provide this with a directory within the source directory for each language subdomain.

For example a spanish/english site running on es.example.com and en.example.com could use:
 
```
> tree source
source
├── en
│   ├── about.html
│   └── contact.html
└── es
    ├── contacto.html
    └── sobre.html 
    
> sculpin generate
    
> tree output_dev
    
output_dev
├── en
│   ├── about.html
│   └── contact.html
└── es
    ├── contacto.html
    └── sobre.html    
``` 
 
This is fine to render the files for each language from a unique source for each subdomain, but if any files need 
to be shared across all subdomains (css/js/images) then either copy/paste or symlinks are required which can get messy 
across many subdomains.

This extension allows you to define a shared directory in the Sculpin source directory for shared assets and define which 
target directories the shared resource should populate.

The example again using the extension setup to share images, js and css:

```
> tree source
source
├── en
│   ├── about.html
│   └── contact.html
├── es
│   ├── contacto.html
│   └── sobre.html
└── shared
    ├── css
    │   └── site.css
    ├── img
    │   └── image.jpg
    └── js
        └── site.js
 
> sculpin generate        
        
> tree output_dev
output_dev
├── en
│   ├── about.html
│   ├── contact.html
│   ├── css
│   │   └── site.css
│   ├── img
│   │   └── image.jpg
│   └── js
│       └── site.js
└── es
    ├── contacto.html
    ├── css
    │   └── site.css
    ├── img
    │   └── image.jpg
    ├── js
    │   └── site.js
    └── sobre.html        
```
 
 

## Installation

Edit your ```sculpin.json``` file:

```json
{
    // ...
    "require": {
        // ...
        "rocketage/sculpin-multilingual-bundle": "@dev"
    }
}
```

and install by running ```sculpin update```.

Now register the bundle in ```app/SculpinKernel.php```:

```php
class SculpinKernel extends \Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel
{
    protected function getAdditionalSculpinBundles()
    {
        return array(
            'Rocketage\Sculpin\Bundle\MultilingualBundle\SculpinMultilingualBundle'
        );
    }
}
```

## Configuration

Define the shared directory name and the target direcotries in the Sculpin app config ```app/config/sculpin_kernel.yml```:

```
sculpin_multilingual:
  shared_directory: 'shared'
  target_directories:
    - en
    - es
```
