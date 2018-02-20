# ZincPHP
## Micro RESTful Api Framework for PHP

<p style="text-align: center;">
<img src='https://i.imgur.com/6JaXF0t.png'/>
</p>

---

### Development status: <span style="color: red">Under actove development - not ready to be used in production - a side project</span>

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
/api/blog/
```
Here is how the block will response to each requests:

- A GET request to `/api/blog/` will redirect to the `/blocks/blog/get.blog.php` file.
- A POST request to `/api/blog/` will redirect to the `/blocks/blog/post.blog.php` file.
- A PUT request to `/api/blog/` will redirect to the `/blocks/blog/put.blog.php` file.
- A DELETE request to `/api/blog/` will redirect to the `/blocks/blog/delete.blog.php` file.

If we want a custom API for example we want to highlight the API version in the path, we can achive this by creating the block with the expected version no. like this:
```
php zinc make:block v1/blog --all
```
This would create the block file inside the `/blocks/v1/blog/` and the API endpoint would be `/api/v1/blog/`

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
- Extendable

## Development Status
ZincPHP is still in development, maintained and developed by [@rakibtg](https://www.twitter.com/rakibtg "Twitter profile")

To use the development version of ZincPHP, please clone the repo and we would love to have your pull requests. ❤️

  [1]: https://i.imgur.com/linBTlE.png