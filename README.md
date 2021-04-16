# yaslob
Yet Another Simple Library Of eBooks

## Context
I was searching a tool to handle my ebooks stored on small server (Netgear Stora in my case). [Calibre](https://calibre-ebook.com/) is a very powerful but too complex and needs a lots of RAM and CPU. [Cops](https://github.com/seblucas/cops) fulfills my needs but still needs a Calibre installation.


## Goals
So YASLOB : Yet Another Simple Library Of eBooks
Requirements, **yaslob** :
  * [X] can be installed on a small server (PHP 5.1.6)
  * [X] does not need lots of dependencies on server side (cannot install anything, because of low space left)
  * [X] allows me to upload a new ebook (in PDF format only)
  * [X] gets automatically : cover image, title, author, year, number of pages
  * [X] allows me to add a description, some tags to describe the ebook, a note
  * [X] uses autocomplete for tags input
  * [ ] offers to search ebooks by tags, date, author, title...
  * [ ] allows me to modify or delete an uploaded ebook
  * [X] can be configured easilly (simple file)
  * [X] follows MVC architecture 
  * [X] doesn't need a database, only an XML file for storing data
  * [X] doesn't need json_encode() and json_decode() functions (PHP 5.1.6)
  * [ ] protect access to some ebooks (Not Safe For Kids)


## Installation
Download all files on your webserver.

The **data** folder must be writable by your server. For example :
```
chown -R www-data:www-data data
```

## Database
Data format in XML file :
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ebooks>
  <ebook>
    <title>6 Pillars Of Creativity</title>
    <author>Tom Fountainhead Geldschläger</author>
    <description>Livre sur les piliers de la créativité</description>
    <year>2020</year>
    <pages>26</pages>
    <date>2021-04-12 10:38:24</date>
    <url>6-pillars-of-creativity</url>
    <note>0</note>
    <nsfk>0</nsfk>
    <tags>
      <tag>creativity</tag>
      <tag>management</tag>
      <tag>crooner</tag>
    </tags>
  </ebook>
</ebooks>
```


## Credits
External libraries used (thank you) :
  * [Bootstrap](https://getbootstrap.com/)
  * [jQuery](https://jquery.com/)
  * [PDF.js](https://mozilla.github.io/pdf.js/)
  * [jQuery Tags Input](http://xoxco.com/projects/code/tagsinput/)

