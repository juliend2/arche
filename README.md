Arche
=====

"But I will establish My covenant with you; and you shall go into the ark — you, your sons, your wife, and your sons’ wives with you. And of every living thing of all flesh you shall bring two of every sort into the ark, to keep them alive with you; they shall be male and female."
-- Genesis 6:18,19

Getting started
---------------

1. Copy `settings/config.tpl.php` to `settings/config.php` and modify to your
   own tastes.
1. Open your browser to http://localhost/arche/ (or the folder where you cloned
   the repo)

The file structure should be self-explanatory if you're familiar with another
MVC framework.

### Quick Facts
* Every model and controller must be included manually inside lib/everything.php.
* Every controller action is a static methods of a controller class.
* There is no ORM. Use the one you like the most.
* You need to have mod_rewrite enabled if you want to use the routes system.


