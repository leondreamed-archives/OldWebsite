# https://www.leonzalion.com
## Structure
A large goal of this redesign was to make a file structure that was easy to manage.

Of course, being easy to manage is subjective. My taste of a well organized file structure is organized into components with each being provided what they require with them in their component section.

As well, a neat file structure seeks to aim for a very small amount of repeated code. This explains why some files have .php extensions when they don't have PHP in them (.php allows for auto_prepend_file and auto_append_file that automatically prepend and append files to the start and end of every PHP file)

Of course, because I'm not following a file structure standard, I believe it's best for me to explain how everything is sorted in my website files.

### Global Folders/Files
**articles** - Contains the articles on my website. Inside the info folder lies the meat of the articles (the actual article text) along with images that are used by that article in the images subfolder.

**pages**	- Contains special pages that fail to fit in an existing page subcategory

**pends** - Contains resources for dynamic prepending and appending of scripts to PHP files

**scripts**	- Contains useful global scripts

**tools** - Tools that I've developed to make lives easier.

### Special Notes
**\*\*/scripts/** - Any PHP files inside a folder with this name will receive a different treatment in file prepends and appends

**cronjob.php** - Includes Cron Jobs to be managed by server to reduce as much client-side dynamic processing as possible for faster loading of pages (e.g. updating static metadata instead of dynamic fetching)
