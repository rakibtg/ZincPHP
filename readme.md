# ZincPHP
## Micro PHP Framework for creating RESTful API

<p style="text-align: center;">
<img src='https://i.imgur.com/4SK3Znp.png'/>
</p>

---

## Development status: 
 - Under active development
 - Not ready to be used in production
 - A side project
 - Working on the documentations, automatic RESTful API testing
 - For any discussion about this framework please direct message me on Twitter at [@rakibtg](https://www.twitter.com/rakibtg "Twitter profile") or mail me at rakibtg@gmail.com 
---

ZincPHP is a lightweight and dependency free PHP framework specially created for REST-ful architecture.

The mission of ZincPHP is to be a simple, reliable, minimal and fast micro-framework. ZincPHP has everything you will need to make a complete REST-ful API backend server.

# Completely New Concept
ZincPHP introduces `block`, which is a combination of Route, Controller and Model!

Assuming that we are going to create a new block for blog posts CRUD, so we will create a block for blog using the ZincCLI command,
```
php zinc make:block blog --all
```
By running the above command, Zinc CLI will create a directory called `blog` inside the `blocks` directory and as we have passed the `--all` argument parameter with the command it will add individual files for general requests.

**Example:**
```
blocks/
-- blog/
-- -- get.blog.php     // Receives GET requests
-- -- post.blog.php    // Receives POST requests
-- -- put.blog.php     // Receives PUT requests
-- -- delete.blog.php  // Receives DELETE requests
```
Now the route path(API endpoint) for this block would be:
```
/blog/
```
Here is how the block will response to each requests:

- A GET request to `/blog/` will redirect to the `/blocks/blog/get.blog.php` file.
- A POST request to `/blog/` will redirect to the `/blocks/blog/post.blog.php` file.
- A PUT request to `/blog/` will redirect to the `/blocks/blog/put.blog.php` file.
- A DELETE request to `/blog/` will redirect to the `/blocks/blog/delete.blog.php` file.

If we want a custom API for example we want to highlight the API version in the path, we can achive this by creating the block with the expected version no. like this:
```
php zinc make:block api/v1/blog --all
```
This would create the block file inside the `/blocks/api/v1/blog/` and the API endpoint would be `/api/v1/blog/`

## Default included features are
- Command line interface for managing the framework
- ZincPHP Block to handle business logic of the app
- Database Migration
- Database Seeder
- An awesome validator
- Helper Functions
- Built-in JWT Auth
- Dynamic routing
- Database Query Builder
- CORS Management
- Configurable
- Built in test framework for REST API's
- Extendable

## Development Status
ZincPHP is still in development, maintained and developed by [@rakibtg](https://www.twitter.com/rakibtg "Twitter profile"), I would love to have your contributions.

To use the development version of ZincPHP, please clone the repo and we would love to have your pull requests. ❤️