Minimal MVC Framework
=====================

This is a research / proof of concept project to build a minimal MVC framework 
in PHP. After looking at several MVC frameworks in PHP, I thought they were
all too complicated to setup, and too over-engineered to my liking.

Things I didn't like, were:

* complicated and deep directory structures were dictated in order to organise Models, Controllers, Views and config files.
* lots of abtraction levels in order to facilitate many use cases I never needed, but was forced to implement because they were there.

My conclusion was actually that there must be reasons I wasn't aware of for
all this complexity. The only way to find out what those were, was to try and 
write it myself. This project is a simple-as-possible MVC framework in less
than 200 LOC. I don't say it's production quality, but it works and has all 
basic features.

Setup
-----

In order to try the framework, you can check out the code, and configure
a webserver to serve the ``public/`` folder as the directory root. If you're
not using Apache, you should replicate the simple mod_rewrite setup from
``public/.htaccess`` in your http server setup.

Usage
-----

If you want to create your own application using the framework, you need to create
a directory somewhere and point the ``$app_dir`` in ``public/index.php`` to it.
By default, controllers and views are expected to be named after their route.

For a page available at ``http://<application-url>/foo/bar``, you should create 
in the application root directory:

- a file ``FooController.php`` containing class ``FooController``
- a directory ``Foo`` with file ``Foo/bar.phtml`` which is the template for the view.

The directory ``example-app`` has two controllers that show basic usage of
controllers and views. The ``PersonsController`` also shows basic usage of a Model
populated with a (read-only) JSON data file.

Documentation
-------------

You can use Doxygen to generate simple API documentation for all files.
After running doxygen, the documentation should be available under doc/, 
or at ``http://<application-url>/doxygen-docs/``
