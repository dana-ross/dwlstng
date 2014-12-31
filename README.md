Dave's WordPress Live Search: The Next Generation
=======

[Dave's WordPress Live Search](https://wordpress.org/plugins/daves-wordpress-live-search/) is a fairly popular WordPress plugin. It's also a huge pain in the ass to maintain.

Dave's WordPress Live Search adds "live search" functionality to your WordPress site. As visitors type words into your WordPress site's search box, the plugin continually queries WordPress, looking for search results that match what the user has typed so far.

Dave's WordPress Live Search was built to work with any other search-related plugin out there because it's just using WordPress's WP_Query class. Heck, recent versions don't even do that, they let WordPress instantiate & configure WP_Query all by itself and just change the parameters a teensy little bit. But by running in an AJAX call to admin_ajax.php, the *correct* way do AJAX in WordPress, all sorts of things break. I even found one other search-related plugin that does nothing if DOING_AJAX is defined! How am I supposed to stay compatible with other plugins if they're doing things like that?

"The Next Generation" of Dave's WordPress Live Search starts with a custom rewrite endpoint, skipping admin_ajax.php and all its quirks completely. It also removes options that were outdated and downright confusing for people. Lastly, I'm using modern dependency management & build tools to streamline the development process.

## License

[MIT](http://daveross.mit-license.org/)

See [why I contribute to open source software](https://davidmichaelross.com/blog/contribute-open-source-software/).

## To-Do

1. A new name! First of all, it shouldn't have "WordPress" in the name for trademark reasons. Second, it shouldn't have "Dave" in it because I want this plugin to belong to the community (a polite way of saying HELP ME OUT HERE, PEOPLE!!)
2. Unit tests (PHPUnit, WP_Mock)
3. Integration tests (PhantomJS, Travis CI)
4. Keyboard navigation of results
