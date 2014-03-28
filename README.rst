Minimal MVC Framework
=====================

This is a research / proof of concept project to build a minimal MVC framework 
in PHP. After looking at several MVC frameworks in PHP, I thought they were
all too complicated to setup, and too over-engineered to my liking.

Things I didn't like, were:

* Complicated and deep directory structures were dictated in order to organise 
  Models, Controllers, Views and config files.
* Lots of abtraction levels in order to facilitate many use cases.

My conclusion was actually that there must be reasons I wasn't aware of for
all this complexity. The only way to find out what those were, was to try it
out myself. This project is simple-as-possible MVC framework in about 200 LOC.
I don't say it's production quality, but it works and has all basic features.

Documentation
-------------

You can use Doxygen to generate simple API documentation for all files.
After running doxygen, the docutentation should be available under doc, or at
http://<application-url>/doxygen-docs/

::
  $ cloc -q mvc/ public/

  http://cloc.sourceforge.net v 1.60  T=0.11 s (62.7 files/s, 3207.0 lines/s)
  -------------------------------------------------------------------------------
  Language                     files          blank        comment           code
  -------------------------------------------------------------------------------
  PHP                              7             55            106            197
  -------------------------------------------------------------------------------
  SUM:                             7             55            106            197
  -------------------------------------------------------------------------------

