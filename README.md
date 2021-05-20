# Fetch Shortcode

Allows you to grab posts through a shortcode and supply a template to style the results.
Use `{{help}}` to see ALL fields.


## Simple Example

```html
[fetch] Show the {{post::post_title}} [/fetch]
```


## Template Moustache Format

{{type::field::level1::level2::level3--function}}



## Moustache Data Types

- post
- meta
- image
- taxonomy
- extra
- help


## Moustache Functions

--sanitize


## Add attributes to fetch shortcode
```html
[fetch posts_per_page='10'] Show the {{post::post_title}} [/fetch]
[fetch post_type='demonstration'] Show the {{post::post_title}} for demonstrations [/fetch]
```



## Different content fields
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


## Add taxonomy / tag filters:
---------------------------
You can change the taxonomy or term in the initial query.
`[fetch taxonomy="tutorial_category" term="cat-leaps"] Show the {{post_title}} [/fetch]`

This will add the following tax_query onto the request for the posts.
```html
['tax_query'] =
    [
        'taxonomy' => $taxonomy,
        'field'    => 'slug',
        'terms'    => $term,
    ],

```

## Content Note:
If the post_content contains {{moustaches}} itself, these will NOT be parsed for now.




## Help Example
```html
<div>
	[fetch post_type="tutorial" posts_per_page='1']{{help}}[/fetch]
</div>
```