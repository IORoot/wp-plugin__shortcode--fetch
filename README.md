
<div id="top"></div>

<div align="center">

<img src="https://svg-rewriter.sachinraja.workers.dev/?url=https%3A%2F%2Fcdn.jsdelivr.net%2Fnpm%2F%40mdi%2Fsvg%406.7.96%2Fsvg%2Fcode-array.svg&fill=%233730A3&width=200px&height=200px" style="width:200px;"/>

<h3 align="center">Shortcode : Fetch</h3>

<p align="center">
    Allows you to obtain posts from wordpress and supply a template to apply to all retrieved results.
</p>    
</div>

##  1. <a name='TableofContents'></a>Table of Contents


* 1. [Table of Contents](#TableofContents)
* 2. [About The Project](#AboutTheProject)
	* 2.1. [Built With](#BuiltWith)
	* 2.2. [Installation](#Installation)
* 3. [Usage](#Usage)
	* 3.1. [Simple Example](#SimpleExample)
	* 3.2. [Template Moustache Format](#TemplateMoustacheFormat)
	* 3.3. [Moustache Data Types](#MoustacheDataTypes)
	* 3.4. [Moustache Functions](#MoustacheFunctions)
	* 3.5. [Add attributes to fetch shortcode](#Addattributestofetchshortcode)
	* 3.6. [Different content fields](#Differentcontentfields)
	* 3.7. [Add taxonomy and tag filters](#Addtaxonomyandtagfilters)
	* 3.8. [Content Note](#ContentNote)
	* 3.9. [Help Example](#HelpExample)
* 4. [Troubleshooting](#Troubleshooting)
* 5. [Contributing](#Contributing)
* 6. [License](#License)
* 7. [Contact](#Contact)
* 8. [Changelog](#Changelog)




##  2. <a name='AboutTheProject'></a>About The Project

Allows you to grab posts through a shortcode and supply a template to style the results.

<p align="right">(<a href="#top">back to top</a>)</p>



###  2.1. <a name='BuiltWith'></a>Built With

This project was built with the following frameworks, technologies and software.

* [PHP](https://php.net/)
* [Wordpress](https://wordpress.org/)
* [Composer](https://getcomposer.org/)
* [Tailwind](https://tailwindcss.com/)

<p align="right">(<a href="#top">back to top</a>)</p>




###  2.2. <a name='Installation'></a>Installation

These are the steps to get up and running with this plugin.

1. Clone the repo into your wordpress plugin folder
    ```sh
    git clone https://github.com/IORoot/wp-plugin__shortcode--fetch ./wp-content/plugins/shortcode-fetch
    ```
1. Composer.
    ```sh
    cd ./wp-content/plugins/shortcode-fetch
    composer install
    ```

<p align="right">(<a href="#top">back to top</a>)</p>



##  3. <a name='Usage'></a>Usage

Allows you to grab posts through a shortcode and supply a template to style the results.
Use `{{help}}` to see ALL fields.


###  3.1. <a name='SimpleExample'></a>Simple Example

```html
    [fetch] Show the {{post::post_title}} [/fetch]
```


###  3.2. <a name='TemplateMoustacheFormat'></a>Template Moustache Format

```php
    {{type::field::level1::level2::level3--function}}
```


###  3.3. <a name='MoustacheDataTypes'></a>Moustache Data Types

Data Types

- post
- meta
- image
- taxonomy
- extra
- help


###  3.4. <a name='MoustacheFunctions'></a>Moustache Functions

```php
    --sanitize
```


###  3.5. <a name='Addattributestofetchshortcode'></a>Add attributes to fetch shortcode

Example:

```php
    [fetch posts_per_page='10'] Show the {{post::post_title}} [/fetch]
    [fetch post_type='demonstration'] Show the {{post::post_title}} for demonstrations [/fetch]
```



###  3.6. <a name='Differentcontentfields'></a>Different content fields

Example: 

```html
    [fetch posts_per_page='1']

        <h2>Post Fields</h2>
        {{post::post_title}} 
        {{extras::permalink}} 

        <h2>Sanitize Fields to make them like a slug</h2>
        {{post::post_title--sanitize}} 

        <h2>Meta Fields</h2>
        {{meta::meta_field}} 

        <h2>Image Fields</h2>
        {{image::url}} 
        {{image::path}} 
        {{image::metadata::width}} 
        {{image::metadata::sizes::thumbnail::file}} 

    [/fetch]
```


###  3.7. <a name='Addtaxonomyandtagfilters'></a>Add taxonomy and tag filters

You can change the taxonomy or term in the initial query.

```html
    [fetch taxonomy="tutorial_category" term="cat-leaps"] Show the {{post_title}} [/fetch]
```

This will add the following tax_query onto the request for the posts.
```html
['tax_query'] =
    [
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $term,
    ],

```

###  3.8. <a name='ContentNote'></a>Content Note
If the post_content contains `{{moustaches}}` itself, these will NOT be parsed for now.


###  3.9. <a name='HelpExample'></a>Help Example
```html
<div>
	[fetch post_type="tutorial" posts_per_page='1']{{help}}[/fetch]
</div>
```



##  4. <a name='Troubleshooting'></a>Troubleshooting
none.

<p align="right">(<a href="#top">back to top</a>)</p>

##  5. <a name='Contributing'></a>Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue.
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



##  6. <a name='License'></a>License

Distributed under the MIT License.

MIT License

Copyright (c) 2022 Andy Pearson

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

<p align="right">(<a href="#top">back to top</a>)</p>



##  7. <a name='Contact'></a>Contact

Author Link: [https://github.com/IORoot](https://github.com/IORoot)

<p align="right">(<a href="#top">back to top</a>)</p>

##  8. <a name='Changelog'></a>Changelog

v1.0.0 - initial version
