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
