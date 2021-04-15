# yaslob
Yet Another Simple Library Of eBooks

## Context
I was searching a tool to handle my ebooks stored on small server (Netgear Stora in my case). [Calibre](https://calibre-ebook.com/) is a very powerful but too complex and needs a lots of RAM and CPU. [Cops](https://github.com/seblucas/cops) fulfills my needs but still needs a Calibre installation.


## Goals
So YASLOB : Yet Another Simple Library Of eBooks
Requirements, **yaslob** :
  * [ ] can be installed on a small server (PHP 5.1.6)
  * [ ] does not need lots of dependencies on server side (cannot install anything, because of space left)
  * [ ] allows me to upload a new ebook (in PDF format only)
  * [ ] gets automatically : cover image, title, author, year, number of pages
  * [ ] allows me to add a description, some tags to describe the ebook, a note
  * [ ] offers to search ebooks by tags, date, author, title...
  * [ ] allows me to modify or delete an uploaded ebook
  * [ ] can be configured easilly (simple file)
  * [ ] follows MVC architecture 
  * [ ] doesn't need a database, only an XML file for storing data
  * [ ] doesn't need json_encode() and json_decode() function (PHP 5.1.6)


## Installation
Download all files on your webserver.


## Credits
External libraries used (thank you) :
  * [Bootstrap](https://getbootstrap.com/)
  * [jQuery](https://jquery.com/)
  * [PDF.js](https://mozilla.github.io/pdf.js/)
  * [jQuery Tags Input](http://xoxco.com/projects/code/tagsinput/)

