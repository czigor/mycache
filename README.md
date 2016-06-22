Tasks
=========

### Preparations

* `git clone https://github.com/czigor/mycache.git`
  
* `drush en mycache`

*  Create 2 additional authenticated users
  
* Prepare a database viewer tool (phpmyadmin, mysql workbench) 
  
* Go to /mycache

### Without page cache, dynamic_page_cache and big_pipe

`drush dis page_cache dynamic_page_cache big_pipe -y`

Answer the following questions for anonymous user and the two authenticated ones.
After changing code/enabling a module use `drush cr` to empty cache tables.
  1. No #cache property
    1. What is in the cache_render table? (keys, tags, data)
    2. What is in the cache_dynamic_page_cache table?
  2. Same a) and b) with only ['#cache']['keys'].
  3. Same a) and b) adding ['#cache']['contexts'].
  
### drush en page_cache
  Same questions 1-3.
  
### drush en dynamic_page_cache
  Same questions 1-3. 
  
### drush en big_pipe