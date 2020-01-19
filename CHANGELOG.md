4.0.1
=====
 - Sitemap generation fix: use absolute urls instead of paths

4.0.0
=====
 - Symfony 4 support.
 - Improve views count (use ajax on page load)
 - Remove non generic features like social integrations, social comments, google analytics integration, statistics etc.
 - Add unit tests
 - Remove useless WYSIWYG options
 - Fix translations issues
 - Refactoring and clean code

3.0.12
======
 - Fix bug with auto detect ckeditor locale (hardcoded English for now)
 
3.0.11
======
 - Fix bug caused by missed dependency (bootstrap tab plugin)
 - Fix bug caused by missed ckeditor plugin (link plugin)
 - Refactor js
 - Clean some code deprecations

3.0.10
======
 - Fix discuss article url
 - Add configurable ShareThis social icons  

3.0.9
=====
 - Fix config reader
 - Add more tests 

3.0.8
=====
 - add some behavioral tests
 
3.0.7
=====
 - translations improvements

3.0.6
=====
 - fix __toString fail because strict type
 
3.0.5
=====
 - Fix assets upload after symfony upgrade 

3.0.2
=====
 - Minor bug fixes
 - Add extra templates extension ability
 - Temporary fix for social services issue

3.0.1
=====
 - Added translations list to the templates
 - Minor corrections to increase code quality

3.0.0
=====
 - Migrated to the Webpack encore with assets prebuilt
 - Minor corrections to increase code quality

2.0.0
=====
 - Migrated to the Symfony >= 3.0

1.1.11
=====
 - Added translations for categories 

1.1.10
=====
 - More SEO improvements:
    - Noindex for homepage pagination (if page > 1)
    - Removed Sitemap generation for archives

1.1.9
=====
 - Different SEO improvements

1.1.8
=====
 - Added support of Sonata Admin 3.*


1.1.7
=====
 - Added lang attribute
 - Added auto setting publishedAt in admin section when switching status to 'isPublished'
 - Tiny new Symfony Yaml component deprecations refactoring (services configurations)


1.1.6
=====
Optimized routes


1.1.5
=====
Dependency fixes


1.1.4
=====
 - Improved dependencies and tested with symfony 2.8
 - Changed default routes pattern (removed trailing slash for articles)
 - Added filters for article admin
 - Added redirect from dashboard to arlicles list (because dashboard is empty and not implemented by the moment)
 - HTML5 fixes


1.1.3
=====
Improved and updates fixtures


1.1.2
=====
Improved image optimization controller: 5xx errors now become 404


1.1.1
=====
Fixed bug, which allowed rate multiple times


1.1.0
=====
- Added image optimization functionality


1.0.6
=====
- Moved sources to src/ directory


1.0.5
=====
- Optimized login page
- Added csrf protection for admin login page


1.0.4
=====

- Fixed bug with tags (Non published articles were shown on tags pages)


1.0.3
=====
-  Refactored and optimized views counter, now views not count if user refresh page


1.0.1
=====

- Optimized dependencies
- Removed meaningless sonata block 


1.0.0
=====

First release
